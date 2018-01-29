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
        $tt = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $timetable);
        $tt = str_replace(['<span>', '</span>', '<p>', '</p>', "Uhr", "\n"], '', $tt);
        $tt = str_replace('<table>', $tableStyle, $tt);
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
        //WKU12, W10/W11, WJU14, W12/W13, WJU16, W14/W15, MKU12, M10/11, MJU14, M12/13, MJU16, M14/15,
        //WK U10, WK U12, WJ U14, WJ U16, WJ U18/U20, MK U10, MK U12, MJ U14, MJ U16, MJ U18/U20
        $sex   = ['WK', 'WJ', 'MK', 'MJ', 'W10/W11', 'W12/W13', 'W14/W15', 'M10/11', 'M12/13', 'M14/15'];
        $class = str_replace($sex, '', $classes);
        $class = str_replace(' ', '', $class);
        $class = explode(',', $class);
        $class = array_unique($class);
        return implode(', ', $class);
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