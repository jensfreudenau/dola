<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 04.12.17
 * Time: 18:18
 */

namespace App\Http\Controllers\Traits;
use App\Helpers;
use App\Helpers\Str;
use DOMDocument;

trait ParseDataTrait
{
    protected function parsingTable($timetable)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($timetable);
        $dom->preserveWhiteSpace = false;
        $tables                  = $dom->getElementsByTagName('table');
        $rows                    = $tables->item(0)->getElementsByTagName('tr');
        $first                   = '<thead>';
        $tableData               = '<tbody>';
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                $cols = $row->getElementsByTagName('td');
                if ($cols->length == 0) {
                    $cols = $row->getElementsByTagName('th');
                }
                $first .= '<tr>';
                foreach ($cols as $col) {
                    $this->fillClassesList($col->nodeValue);
                    $first .= '<td>' . $this->prepareAgeclassData($col->nodeValue) . '</td>';
                }
                $first .= '</tr>';
            } else {
                $cols      = $row->getElementsByTagName('td');
                $tableData .= '<tr>';
                foreach ($cols as $dataKey => $col) {
                    if ($dataKey > 0 && ($col->nodeValue != " ")) {
                        $this->fillDisciplineList($col->nodeValue);
                    }
                    $tableData .= '<td>' . $this->prepareDisciplineData($col->nodeValue) . '</td>';
                }
                $tableData .= '</tr>';
            }
        }
        $first .= '</thead>';
        return '<table>' . $first . $tableData . '</tbody></table>';
    }

    protected function fillClassesList($class)
    {
        $class = str_replace('*', '', $class);
        $class = $this->prepareAgeclassData($class);
        if (false !== strpos($class, '/')) {
            #[$class, $secondClass] = explode('/', $class); /PHP7
            list($class, $secondClass) = explode('/', $class);
            if ($secondClass) {
                $secondClass          = trim($secondClass);
                $len                  = strlen(trim($secondClass));
                $primaryClass         = substr($class, 0, -$len);
                $secondClassName      = $primaryClass . $secondClass;
                $this->ageclassList[] = $secondClassName;
            }
        }
        $this->ageclassList[] = $class;
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

    protected function fillDisciplineList($col)
    {
        if (strpos($col, '/')) {
            #[$firstArg, $secondArg] = explode('/', $col); //php7
            list($firstArg, $secondArg) = explode('/', $col);
            $this->disciplineList[] = $this->prepareDisciplineData($firstArg, true);
            $this->disciplineList[] = $this->prepareDisciplineData($secondArg, true);
        } else {
            $this->disciplineList[] = $this->prepareDisciplineData($col, true);
        }
        $this->disciplineList = array_filter($this->disciplineList);
        $this->disciplineList = array_unique($this->disciplineList);
    }

    protected function prepareDisciplineData($str, $forList = false)
    {
        $str = (string)Str::from($str)->trim();
        $str = $this->checkM($str);
        $str = $this->checkX($str);
        if($forList){
            $str = $this->checkZ($str);
            $str = $this->checkJumpDisciplines($str);
        }
        $str = $this->checkH($str);

        $str = trim($str);
        return $str ;
    }

    /**
     * @param $str
     * @return mixed
     */
    protected function checkZ($str)
    {
        if(Str::from($str)->contains('Z')) {
            return (string) Str::from($str)->beforeFirst('Z');
        }
        else {
            return $str;
        }
    }

    protected function checkJumpDisciplines($str)
    {
        $jumps = array('Weit', 'Hoch', 'Kugel');
        if(Str::from($str)->contains($jumps[0])
            || Str::from($str)->contains($jumps[1])
            || Str::from($str)->contains($jumps[2])
        ) {
            if(strlen($jumps[0]) < strlen($str))
                return (string) Str::from($str)->beforeFirst(' ');
        }
        else {
            return $str;
        }
    }

    protected function checkH($str)
    {
        return $str;
    }

    protected function checkX($str)
    {
        $pos = strpos($str, 'x');
        if($pos == false) return $str;
        if ($str[$pos - 1] != ' ' && $str[$pos + 1] != ' ') {
            $str = str_replace('x', ' x ', $str);
        }
        return trim($str);
    }
    protected function checkM($str)
    {
        $pos = strpos($str, 'm');
        if($pos == false) return $str;
        $newPos = $pos - 1;
        if ($str[$newPos] != ' ') {
            $str = str_replace('m', ' m', $str);
        }
        return $str;
    }

    protected function markFounded($timetable, $collection)
    {
        foreach ($collection as $ageclass) {
            $timetable = $this->setMarker($ageclass->shortname, $timetable);
            $timetable = $this->setMarker($ageclass->rieping, $timetable);
        }

        return $timetable;
    }

    protected function setMarker($search, $haystack)
    {
        return str_replace($search, '<span style="color:green">' . $search . '</span>', $haystack);
    }

    protected function replaceTableTag($timetable_1, $tableStyle, $tableHeadStyle)
    {
        $tt = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $timetable_1);
        $tt = str_replace(['<span>', '</span>', '<p>', '</p>', "Uhr", "\n"], '', $tt);
        $tt = str_replace('<table>', $tableStyle, $tt);
        return str_replace('<thead>', $tableHeadStyle, $tt);
    }

    protected function trimClasses($classes)
    {
        $classes = str_replace(',', '|', $classes);
        $classes = str_replace(' ', '', $classes);
        return str_replace('|', ', ', $classes);
    }
}