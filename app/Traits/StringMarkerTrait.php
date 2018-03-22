<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 25.01.18
 * Time: 11:01
 */

namespace App\Traits;
trait StringMarkerTrait
{
    /**
     * @param $timetable
     * @param $tableStyle
     * @param $tableHeadStyle
     * @return mixed
     */
    protected function replaceTableTag($timetable, $tableStyle, $tableHeadStyle)
    {
        $tt = str_replace('<table>', $tableStyle, $timetable);
        return str_replace('<thead>', $tableHeadStyle, $tt);
    }

    /**
     * @param $classes
     * @return mixed
     */
    protected function prepareClasses($classes)
    {
        $classes = str_replace(',', '|', $classes);
        $classes = str_replace(' ', '', $classes);
        return str_replace('|', ', ', $classes);
    }

    /**
     * @param $classes
     * @return string
     */
    public function trimClasses($classes)
    {
        $classTrimmed = [];
        $sex   = ['WK', 'WJ', 'MK', 'MJ', 'W10/W11', 'W12/W13', 'W14/W15', 'M10/11', 'M12/13', 'M14/15', 'MJ', 'WJ'];
        foreach ($classes as $class) {
            $trimmed = str_replace($sex, '', $class->shortname);
            $classTrimmed[] = str_replace(' ', '', $trimmed);
        }
        return $classTrimmed = array_unique($classTrimmed);
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
}