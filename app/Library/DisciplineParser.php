<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 01.10.18
 * Time: 15:14
 */

namespace App\Library;

use App\Helpers\Str;
use App\Models\Discipline;

class DisciplineParser
{
    protected $domDisciplines;
    protected $disciplines;
    protected $preparedDisciplines;
    protected $disciplineCollectionError;

    public function setDomDisciplines($domDisciplines)
    {
        $this->domDisciplines = $domDisciplines;
    }

    public function proceed($body)
    {
        $this->setDomDisciplines($body);
        $this->domToDisciplines();
        $this->proof();
    }

    public function domToDisciplines() :void
    {
        $rows = $this->domDisciplines->getElementsByTagName('tr');
        foreach ($rows AS $tr) {
            foreach ($tr->childNodes as $key => $td) {
                if ($key == 0) {
                    continue;
                }
                if ('Zeit' == $td->textContent) {
                    continue;
                }
                if (strlen($td->textContent) < 3) {
                    continue;
                }
                $this->fillDisciplineList($td->textContent);
            }
        }
    }

    public function getDisciplines()
    {
        return $this->disciplines;
    }

    protected function proof() :void
    {
        foreach ($this->preparedDisciplines as $discipline) {
            $this->proofDiscipline($discipline);
        }
    }

    protected function fillDisciplineList($discipline): void
    {
        if (strpos($discipline, '/')) {
            [$firstArg, $secondArg] = explode('/', $discipline);
            $this->preparedDisciplines[] = $this->prepareDisciplineData($firstArg);
            $this->preparedDisciplines[] = $this->prepareDisciplineData($secondArg);
        } else {
            $this->preparedDisciplines[] = $this->prepareDisciplineData($discipline);
        }
        $this->preparedDisciplines = array_filter($this->preparedDisciplines);
        $this->preparedDisciplines = array_unique($this->preparedDisciplines);
    }

    protected function prepareDisciplineData($str)
    {
        $str = (string)Str::from($str)->trim();
        $str = $this->checkJumpDisciplines($str);
        $str = $this->checkRunDiscipline($str);
        $str = $this->checkX($str);
        $str = $this->checkZ($str);
        $str = trim($str);

        return $str;
    }

    protected function checkRunDiscipline($str)
    {
        $pos = strpos($str, '0m');
        if ($pos == false) {
            return $str;
        }
        $newPos = $pos - 1;
        if ($str[$newPos] != ' ') {
            $str = str_replace('m', ' m', $str);
        }

        return $str;
    }

    protected function checkX($str)
    {
        $pos = strpos($str, 'x');
        if ($pos == false) {
            return $str;
        }
        if ($str[$pos - 1] != ' ' && $str[$pos + 1] != ' ') {
            $str = str_replace('x', ' x ', $str);
        }

        return trim($str);
    }

    protected function checkZ($str)
    {
        if (Str::from($str)->contains('Z')) {
            return trim((string)Str::from($str)->beforeFirst('Z'));
        } else {
            return $str;
        }
    }

    protected function checkJumpDisciplines($str)
    {
        $jumps = array('Weit', 'Hoch', 'Kugel');
        if (Str::from($str)->contains($jumps[0])) {
            return $jumps[0];
        }
        if (Str::from($str)->contains($jumps[1])) {
            return $jumps[1];
        }
        if (Str::from($str)->contains($jumps[2])) {
            return $jumps[2];
        }

        return $str;
    }

    protected function proofDiscipline($disciplineStr) :void
    {
        $discipline = Discipline::where('shortname', '=', $disciplineStr)
            ->orWhere('ladv', '=', $disciplineStr)
            ->orWhere('name', '=', $disciplineStr)
            ->orWhere('rieping', '=', $disciplineStr)
            ->select('id', 'ladv', 'shortname', 'rieping')->first();
        if (!$discipline) {
            $this->disciplineCollectionError[] = $disciplineStr;
        } else {
            $this->disciplines[$discipline->id] = [
                'shortname' => $discipline->shortname,
                'rieping'   => $discipline->rieping,
                'ladv'      => $discipline->ladv,
                'id'        => $discipline->id,
            ];
        }
    }
}