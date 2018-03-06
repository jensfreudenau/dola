<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 06.03.18
 * Time: 08:58
 */

namespace App\Library;
class Ageclass extends Dom
{
    protected $domAgeclasses;
    protected $classes = [];

    public function setDomAgeclasses($domAgeclasses)
    {
        $this->domAgeclasses = $domAgeclasses;
    }

    public function iterateAgeclassCollection()
    {
        foreach ($this->domAgeclasses->childNodes AS $tr) {
            foreach ($tr->childNodes AS $td) {
                if ('Zeit' == $td->textContent) continue;
                if (strlen($td->textContent) < 3) continue;
                $class = $this->prepareAgeclassData($td->textContent);
                $this->fillAgeclassesList($class);
            }
        }
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

    protected function fillAgeclassesList($class)
    {
        $class = str_replace('*', '', $class);
        if (false !== strpos($class, '/')) {
            [$class, $secondClass] = explode('/', $class);
            if ($secondClass) {
                $secondClass     = trim($secondClass);
                $len             = strlen(trim($secondClass));
                $primaryClass    = substr($class, 0, -$len);
                $secondClassName = $primaryClass . $secondClass;
                $this->classes[] = $secondClassName;
            }
        }
        $this->classes[] = $class;
        return true;
    }

    public function getAgeclasses()
    {
        return $this->classes;
    }
}