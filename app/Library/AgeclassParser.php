<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 27.09.18
 * Time: 12:58
 */

namespace App\Library;

use App\Models\Ageclass;

class AgeclassParser
{
    protected $headerAgeclasses;
    protected $domAgeclasses;
    protected $ageclassErrorCollection;
    protected $ageclassCollection;
    protected $header;
    protected $ageclasses;
    protected $preparedAgeclasses;

    public function proceed($header)
    {
        $this->setDomAgeclasses($header);
        $this->domToAgeclasses();
        $this->proof();
    }

    /**
     * @return array
     */
    public function getAgeclasses(): array
    {
        return $this->ageclasses;
    }

    public function setDomAgeclasses($domAgeclasses): void
    {
        $this->domAgeclasses = $domAgeclasses;
    }

    public function getAgeclassErrorCollection()
    {
        return $this->ageclassErrorCollection;
    }

    protected function proof(): void
    {
        foreach ($this->preparedAgeclasses as $ageclassList) {
            $this->proofAgeclass($ageclassList);
        }
    }

    protected function domToAgeclasses(): void
    {
        foreach ($this->domAgeclasses->childNodes AS $tr) {
            foreach ($tr->childNodes AS $td) {
                if ('Zeit' == $td->textContent) {
                    continue;
                }
                if (strlen($td->textContent) < 3) {
                    continue;
                }
                $class = $this->prepareAgeclassData($td->textContent);
                $this->fillAgeclassesList($class);
            }
        }
    }

    protected function prepareAgeclassData($str)
    {
        $str = trim($str);
        $str = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
        $pos = strpos($str, 'U');
        if ($str[$pos + 1] === ' ') {
            $str = str_replace('U ', 'U', $str);
        }

        return $str;
    }

    protected function fillAgeclassesList($class): void
    {
        $class = str_replace('*', '', $class);
        if (false !== strpos($class, '/')) {
            [$class, $secondClass] = explode('/', $class);
            if ($secondClass) {
                $secondClass        = trim($secondClass);
                $len                = \strlen(trim($secondClass));
                $primaryClass       = substr($class, 0, -$len);
                $secondClassName    = $primaryClass.$secondClass;
                $this->preparedAgeclasses[] = $secondClassName;
            }
        }
        $this->preparedAgeclasses[] = $class;

    }

    protected function iterateAgeclasses(): void
    {
        if (!empty($this->domAgeclasses)) {
            foreach ($this->domAgeclasses->childNodes AS $tr) {
                foreach ($tr->childNodes AS $td) {
                    if ('Zeit' === $td->textContent) {
                        continue;
                    }
                    if (strlen($td->textContent) < 3) {
                        continue;
                    }
                    $class = $this->prepareAgeclassData($td->textContent);
                    $this->fillAgeclassesList($class);
                }
            }
        }
    }

    protected function proofAgeclass($ageclassStr): void
    {
        $ageclass = Ageclass::where('shortname', '=', $ageclassStr)
            ->orWhere('ladv', '=', $ageclassStr)
            ->orWhere('name', '=', $ageclassStr)
            ->orWhere('rieping', '=', $ageclassStr)
            ->select('id', 'ladv', 'shortname', 'rieping')->first();
        if (!$ageclass) {
            $this->ageclassErrorCollection[] = $ageclassStr;
        } else {
            $this->ageclasses[$ageclass->id] = [
                'shortname' => $ageclass->shortname,
                'rieping'   => $ageclass->rieping,
                'ladv'      => $ageclass->ladv,
                'id'        => $ageclass->id,
            ];
        }
    }
}