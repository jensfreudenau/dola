<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 28.12.15
 * Time: 15:25
 */

namespace App\Helpers;

class Utils
{
    public static function after($ext, $inthat)
    {
        if (!is_bool(strpos($inthat, $ext)))
            return substr($inthat, strpos($inthat, $ext) + strlen($ext));
        return false;
    }

    public static function after_last($ext, $inthat)
    {
        if (!is_bool(Utils::strrevpos($inthat, $ext)))
            return substr($inthat, Utils::strrevpos($inthat, $ext) + strlen($ext));
        return false;
    }

    public static function before($ext, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $ext));
    }

    public static function before_last($ext, $inthat)
    {
        return substr($inthat, 0, Utils::strrevpos($inthat, $ext));
    }

    public static function between($ext, $that, $inthat)
    {
        return Utils::before($that, Utils::after($ext, $inthat));
    }

    public static function between_last($ext, $that, $inthat)
    {
        return Utils::after_last($ext, Utils::before_last($that, $inthat));
    }

    public static function strrevpos($instr, $needle)
    {
        $rev_pos = strpos(strrev($instr), strrev($needle));
        if ($rev_pos === false) return false;
        else return strlen($instr) - $rev_pos - strlen($needle);
    }

}