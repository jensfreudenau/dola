<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 04.12.17
 * Time: 18:18
 */

namespace App\Http\Controllers\Traits;

use App\Ageclass;
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
            $this->disciplineList[] = $this->prepareDisciplineData($firstArg);
            $this->disciplineList[] = $this->prepareDisciplineData($secondArg);
        } else {
            $this->disciplineList[] = $this->prepareDisciplineData($col);
        }
        $this->disciplineList = array_unique($this->disciplineList);
    }

    protected function prepareDisciplineData($str)
    {
        $str = trim($str);
        $pos = strpos($str, 'm');
        if ($str[$pos - 1] != ' ') {
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