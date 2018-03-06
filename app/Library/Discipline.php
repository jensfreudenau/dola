<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 06.03.18
 * Time: 08:58
 */

namespace App\Library;
use App\Helpers\Str;

class Discipline extends Dom
{
    protected $domDisciplines;
    protected $disciplines;

    public function setDomDisciplines($domDisciplines)
    {
        $this->domDisciplines = $domDisciplines;
    }

    public function iterateDisciplineCollection()
    {
        $rows = $this->domDisciplines->getElementsByTagName('tr');
        foreach ($rows AS $tr) {
            foreach ($tr->childNodes as $key => $td) {
                if ($key == 0) continue;
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

    protected function prepareDisciplineData($str, $forList = false)
    {
        $str = (string)Str::from($str)->trim();
        $str = $this->checkM($str);
        $str = $this->checkX($str);
//        if ($forList) {
            $str = $this->checkZ($str);
            $str = $this->checkJumpDisciplines($str);
//        }

        $str = trim($str);
        return $str;
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



    protected function searchDisciplines()
    {
        $table = $this->dom->getElementsByTagName('table');
        $rows  = $table->item(0)->getElementsByTagName('tr');
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }
            $cols     = $row->getElementsByTagName('td');
            foreach ($cols as $dataKey => $col) {
                if ($dataKey > 0 && ($col->nodeValue != " ")) {
                    $this->fillDisciplineList($col->nodeValue);
                }
            }
        }
        return true;
    }

    public function getDisciplines()
    {
        return $this->disciplines;
    }
}