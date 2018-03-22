<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 21.03.18
 * Time: 14:55
 */

namespace App\Services;

use App\Helpers\Str;
use App\Models\Discipline;
use DOMDocument;

/**
 * @property DOMDocument dom
 */
class DisciplineService
{
    protected $disciplineCollection      = array();
    protected $disciplineCollectionError = array();
    protected $domDisciplines;
    protected $disciplines;
    protected $dom;

    public function __construct()
    {
        $this->dom                     = new DOMDocument();
        $this->dom->preserveWhiteSpace = false;
    }

    /**
     * @param $id
     */
    public function attacheDisciplines($id)
    {
        foreach ($this->getProofedDisciplines() as $key => $class) {
            $discipline = Discipline::where('ladv', '=', $key)->first();
            $discipline->competitions()->attach($id);
        }
    }

    public function createDisciplines()
    {

    }
    /**
     * @return array
     */
    public function getProofedDisciplines()
    {
        return $this->disciplineCollection;
    }

    /**
     * @return array
     */
    public function getDisciplineCollection(): array
    {
        return $this->disciplineCollection;
    }

    /**
     * @return array
     */
    public function getDisciplineCollectionError(): array
    {
        return $this->disciplineCollectionError;
    }

    public function getErrorlists()
    {
        return ['disciplineError' => $this->disciplineCollectionError];
    }

    public function parseDisciplines($body)
    {
        $this->setDomDisciplines($body);
        $this->iterateDisciplineCollection();
        foreach ($this->getDisciplines() as $discipline) {
            $this->proofDisciplineCollection($discipline);
        }
    }

    public function setDomDisciplines($domDisciplines)
    {
        $this->domDisciplines = $domDisciplines;
    }

    public function iterateDisciplineCollection()
    {
        $rows = $this->domDisciplines->getElementsByTagName('tr');
        foreach ($rows AS $tr) {
            foreach ($tr->childNodes as $key => $td) {
                #if ($key == 0) continue;
                if (strlen($td->textContent) < 3) continue;
                $this->fillDisciplineList($td->textContent);
            }
        }
    }

    protected function fillDisciplineList($col)
    {
        if (strpos($col, '/')) {
            [$firstArg, $secondArg] = explode('/', $col);
            $this->disciplines[] = $this->prepareDisciplineData($firstArg, true);
            $this->disciplines[] = $this->prepareDisciplineData($secondArg, true);
        } else {
            $this->disciplines[] = $this->prepareDisciplineData($col, true);
        }
        $this->disciplines = array_filter($this->disciplines);
        $this->disciplines = array_unique($this->disciplines);
    }

    public function syncDisciplines($competition)
    {
        $disciplineIds = [];
        foreach ($this->getProofedDisciplines() as $disciplineKey => $discipline) {
            $data            = Discipline::where('ladv', '=', $disciplineKey)->select('id')->get()->toArray();
            $disciplineIds[] = $data[0]['id'];
        }
        $competition->disciplines()->sync($disciplineIds);
    }


    protected function prepareDisciplineData($str, $forList = false)
    {
        $str = (string)Str::from($str)->trim();
        $str = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
        $str = $this->checkX($str);
        $str = $this->checkZ($str);
        $str = $this->checkJumpDisciplines($str);
        $str = trim($str);
        return $str;
    }

    protected function checkX($str)
    {
        $pos = strpos($str, 'x');
        if ($pos == false) return $str;
        if ($str[$pos - 1] != ' ' && $str[$pos + 1] != ' ') {
            $str = str_replace('x', ' x ', $str);
        }
        return trim($str);
    }

    /**
     * @param $str
     * @return mixed
     */
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

    public function getDisciplines()
    {
        return $this->disciplines;
    }

    protected function proofDisciplineCollection($disciplineStr)
    {
        $discipline = Discipline::where('shortname', '=', $disciplineStr)
                                ->orWhere('ladv', '=', $disciplineStr)
                                ->orWhere('name', '=', $disciplineStr)
                                ->orWhere('rieping', '=', $disciplineStr)
                                ->select('ladv', 'shortname')->first();
        if (!$discipline) {
            $this->disciplineCollectionError[] = $disciplineStr;
        } else {
            $this->disciplineCollection[$discipline->ladv] = [$discipline->shortname, $disciplineStr];
        }
    }

    protected function checkM($str)
    {
        $pos = strpos($str, 'm');
        if ($pos == false) return $str;
        $newPos = $pos - 1;
        if ($str[$newPos] != ' ') {
            $str = str_replace('m', ' m', $str);
        }
        return $str;
    }

    protected function searchDisciplines()
    {
        $table = $this->dom->getElementsByTagName('table');
        $rows  = $table->item(0)->getElementsByTagName('tr');
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }
            $cols = $row->getElementsByTagName('td');
            foreach ($cols as $dataKey => $col) {
                if ($dataKey > 0 && ($col->nodeValue != " ")) {
                    $this->fillDisciplineList($col->nodeValue);
                }
            }
        }
        return true;
    }
}