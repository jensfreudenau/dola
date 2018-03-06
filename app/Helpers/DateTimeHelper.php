<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 28.12.15
 * Time: 15:25
 */

namespace App\Helpers;
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

    public function __construct()
    {
        $datum = '10. Mai 2019';

        $loc=setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'deu_deu');
        #echo strftime('%B');
        setlocale(LC_TIME, 'German');
        Carbon::setLocale('de');
        $this->dt =  Carbon::now('Europe/Berlin');
        $dob = Carbon::parse($datum, 'Europe/Berlin')->format($this->formats[3]);
        echo $dob;
//        $erg = Carbon::createFromFormat('d.m.Y', $datum);
//        $erg = Carbon::parse($datum);
//        dump($erg);
        #echo $this->dt->formatLocalized('%d %F %Y');
        #echo Carbon::createFromFormat(config('app.date_locale_format'), '01.02.2018')->format($this->formats[3]);
//
//        echo $this->dt->format('d. F Y');
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
    public function validateDate($date, $format)
    {
        $d = DateTime::createFromFormat($format, $date);
        echo '<pre>:'.__LINE__;
        echo '<br><strong>';
        print_r($d);
        echo '</strong></pre>';
        return $d && $d->format($format) == $date;
    }
}