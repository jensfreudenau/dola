<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 25.01.18
 * Time: 10:35
 */

namespace App\Traits;

use App\Helpers\Str;
use DOMDocument;

trait ParseDataTrait
{
    /**
    protected $table          = '';
    protected $disciplineList = [];
    protected $ageclassList   = [];
    protected $dom;

    public function createDomObject($timetable)
    {
        $this->dom = new DOMDocument();
        $this->dom->loadHTML(mb_convert_encoding($timetable, 'HTML-ENTITIES', 'UTF-8'));
        $this->dom->preserveWhiteSpace = false;
    }

    public function parsingTable()
    {
        $table                   = $this->dom->getElementsByTagName('table');
        $rows                    = $table->item(0)->getElementsByTagName('tr');
        $tableRows               = '';
        $tableHeader             = '';
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                $tableHeader = $this->createTableFirstRow($row);
            } else {
                $tableRows .= $this->createTableRow($row);
            }
        }
        $this->table = '<table><thead>' . $tableHeader . '</thead><tbody>' . $tableRows . '</tbody></table>';
    }


    protected function createTableFirstRow($row)
    {
        $tableFirstRow = '';
        $cols          = $row->getElementsByTagName('td');
        if ($cols->length == 0) {
            $cols = $row->getElementsByTagName('th');
        }
        $tableFirstRow .= '<tr>';
        foreach ($cols as $col) {
            $tableFirstRow .= '<td>' . $this->prepareAgeclassData($col->nodeValue) . '</td>';
        }
        $tableFirstRow .= '</tr>';
        return $tableFirstRow;
    }

    protected function prepareAgeclassData($str)
    {
        $str = trim($str);
        $pos = strpos($str, 'U');
        if ($str[$pos + 1] == ' ') {
            $str = str_replace('U ', 'U', $str);
        }
        return $str;
    }

    protected function createTableRow($row)
    {
        $cols     = $row->getElementsByTagName('td');
        $tableRow = '<tr>';
        foreach ($cols as $dataKey => $col) {
            $tableRow .= '<td>' . $this->prepareDisciplineData($col->nodeValue) . '</td>';
        }
        $tableRow .= '</tr>';
        return $tableRow;
    }



    protected function prepareDisciplineData($str, $forList = false)
    {
        $str = (string)Str::from($str)->trim();
        $str = $this->checkM($str);
        $str = $this->checkX($str);
        if ($forList) {
            $str = $this->checkZ($str);
            $str = $this->checkJumpDisciplines($str);
        }
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

    protected function searchAgeclasses()
    {
        $table = $this->dom->getElementsByTagName('table');
        $rows  = $table->item(0)->getElementsByTagName('tr');
        foreach ($rows as $key => $row) {
            if ($key > 0) {
                return true;
            }
            $cols = $row->getElementsByTagName('td');
            if ($cols->length == 0) {
                $cols = $row->getElementsByTagName('th');
            }
            foreach ($cols as $col) {
                $this->fillAgeclassesList($col->nodeValue);
            }
        }
        return true;
    }

    protected function fillDisciplineList($col)
    {
        if (strpos($col, '/')) {
            [$firstArg, $secondArg] = explode('/', $col);
            $this->disciplineList[] = $this->prepareDisciplineData($firstArg, true);
            $this->disciplineList[] = $this->prepareDisciplineData($secondArg, true);
        } else {
            $this->disciplineList[] = $this->prepareDisciplineData($col, true);
        }
        $this->disciplineList = array_filter($this->disciplineList);
        $this->disciplineList = array_unique($this->disciplineList);
    }


    protected function fillAgeclassesList($class)
    {
        $class = str_replace('*', '', $class);
        if ('Zeit' == $class) return true;
//        $class = $this->prepareAgeclassData($class);
        if (false !== strpos($class, '/')) {
            [$class, $secondClass] = explode('/', $class);
            if ($secondClass) {
                $secondClass          = trim($secondClass);
                $len                  = strlen(trim($secondClass));
                $primaryClass         = substr($class, 0, -$len);
                $secondClassName      = $primaryClass . $secondClass;
                $this->ageclassList[] = $secondClassName;
            }
        }
        $this->ageclassList[] = $class;
        return true;
    }


    public function getParsedTable(): string
    {
        return $this->table;
    }


    public function getDisciplinesFromTable(): array
    {
        return $this->disciplineList;
    }


    public function getAgeclassesFromTable(): array
    {
        return $this->ageclassList;
    }
    */
}