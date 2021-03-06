<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 28.12.15
 * Time: 15:25
 */

namespace App\Helpers;
use DateTime;
use Illuminate\Support\Carbon;

class DateTimeHelper
{
    protected $dt;
    protected $formats = [
        'd.m.Y', //01.02.2018
        'd.n.Y', //01.2.2018
        'j.n.Y', //1.2.2018
        'd. F Y', //01. Januar 2018
        'j. F Y', //1. Januar 2018
        'j.m.Y', //1.02.2018
    ];

    /**
     * @param $files
     * @return array
     */
    public static function listdir_by_date($files)
    {
        $list = [];
        foreach ($files as $key => $file) {
            if (basename($file) == 'styles.css') continue;
            if (basename($file) == 'index.html') continue;
            // add the filename, to be sure not to
            // overwrite a array key
            list($filebase, $ending) = explode(".", $file);
            if ($ending != 'html' AND $ending != 'pdf') continue;
//
            preg_match_all('/[0-9]/', $filebase, $match);
            if (count($match[0]) < 6) continue;
            $six = false;
            if (count($match[0]) == 6) {
                $six = true;
            }
            if (count($match[0]) > 8) {
                $match[0][8] = '';
            }
            $v = implode($match[0]);
            if ($six) {
                $v = '20' . $v;
            }
            try {
                $date = new \DateTime($v);
                $list[$date->format('Y')][$key]['file'] = $file;
                $list[$date->format('Y')][$key]['date'] = $date->format('d.m.Y');
            } catch (\Exception $e) {
                //echo $e->getMessage();
            }
        }
        return $list;
    }



    public function checkFormats($string)
    {
        foreach ($this->formats as $key => $format) {
            if($this->validateDate($string, $format)){
                echo 'treffer:'.$format;
                return;
            }
        }
    }


    /**
     * @param $range
     * @return string
     */
    public static function createBirthyearRange($range)
    {
        $ageGroup = '';
        [$rangeStart, $rangeEnd] = explode('-', $range);
        $ageGroup .= Carbon::now()->year - $rangeEnd;
        $ageGroup .= '-';
        $ageGroup .= Carbon::now()->year - $rangeStart;
        return $ageGroup;
    }
}