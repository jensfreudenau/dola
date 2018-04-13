<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 21.03.18
 * Time: 14:54
 */

namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Models\Ageclass;
use App\Repositories\Ageclass\AgeclassRepositoryInterface;
use DOMDocument;

/**
 * @property DOMDocument dom
 */
class AgeclassService
{
    /**
     * @param $id
     */
    protected $ageclassCollection      = array();
    protected $ageclassCollectionError = array();
    protected $domAgeclasses;
    protected $classes                 = [];
    protected $dom;
    /** @var AgeclassRepositoryInterface  */
    protected $ageclassRepository;

    public function __construct(AgeclassRepositoryInterface $ageclassRepository)
    {
        $this->ageclassRepository = $ageclassRepository;
        $this->dom                     = new DOMDocument();
        $this->dom->preserveWhiteSpace = false;
    }

    /**
     * @param $id
     */
    public function attachAgeclasses($id)
    {
        foreach ($this->getProofedAgeclasses() as $key => $class) {
            $ageClass = Ageclass::where('ladv', '=', $key)->first();
            $ageClass->competitions()->attach($id);
        }
    }

    /**
     * @return array
     */
    public function getProofedAgeclasses()
    {
        return $this->ageclassCollection;
    }

    /**
     * @param $competition
     */
    public function syncAgeClasses($competition)
    {
        $ageclassIds = [];
        foreach ($this->getProofedAgeclasses() as $ageclassKey => $ageclass) {
            $data          = Ageclass::where('ladv', '=', $ageclassKey)->select('id')->get()->toArray();
            $ageclassIds[] = $data[0]['id'];
        }
        $competition->Ageclasses()->sync($ageclassIds);
    }

    /**
     * @param $header
     */
    public function parseAgeclasses($header)
    {
        $this->setDomAgeclasses($header);
        $this->iterateAgeclassCollection();
        foreach ($this->getAgeclasses() as $ageclassList) {
            $this->proofAgeclassCollection($ageclassList);
        }
    }

    /**
     * @param $domAgeclasses
     */
    public function setDomAgeclasses($domAgeclasses)
    {
        $this->domAgeclasses = $domAgeclasses;
    }

    /**
     *
     */
    public function iterateAgeclassCollection()
    {
        if (!empty($this->domAgeclasses)) {
            foreach ($this->domAgeclasses->childNodes AS $tr) {
                foreach ($tr->childNodes AS $td) {
                    if ('Zeit' == $td->textContent) continue;
                    if (strlen($td->textContent) < 3) continue;
                    $class = $this->prepareAgeclassData($td->textContent);
                    $this->fillAgeclassesList($class);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function loadAgeclasses()
    {
        $classes    = $this->ageclassRepository->whereNotNull('order');
        $ageclasses = [];
        foreach ($classes as $key => $class) {
            $ageclasses[$key]['yearRange'] = DateTimeHelper::createBirthyearRange($class->year_range);
            $ageclasses[$key]['ageRange']  = $class->year_range;
            $ageclasses[$key]['shortname'] = $class->shortname;
            $ageclasses[$key]['name']      = $class->name;
        }
        return $ageclasses;
    }

    /**
     * @param $str
     * @return mixed|null|string|string[]
     */
    protected function prepareAgeclassData($str)
    {
        $str = trim($str);
        $str = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
        $pos = strpos($str, 'U');
        if ($str[$pos + 1] == ' ') {
            $str = str_replace('U ', 'U', $str);
        }
        return $str;
    }

    /**
     * @param $class
     * @return bool
     */
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

    /**
     * @return array
     */
    public function getAgeclasses()
    {
        return $this->classes;
    }

    /**
     * @param $ageclassStr
     */
    protected function proofAgeclassCollection($ageclassStr)
    {
        $ageclass = Ageclass::where('shortname', '=', $ageclassStr)
                            ->orWhere('ladv', '=', $ageclassStr)
                            ->orWhere('name', '=', $ageclassStr)
                            ->orWhere('rieping', '=', $ageclassStr)
                            ->select('ladv', 'shortname')->first();
        if (!$ageclass) {
            $this->ageclassCollectionError[] = $ageclassStr;
        } else {
            $this->ageclassCollection[$ageclass->ladv] = [$ageclass->shortname, $ageclassStr];
        }
    }

    /**
     * @return array
     */
    public function getErrorlists()
    {
        return ['ageclassError' => $this->ageclassCollectionError];
    }

    /**
     * @return array
     */
    public function getAgeclassCollectionError(): array
    {
        return $this->ageclassCollectionError;
    }

    /**
     * @return array
     */
    public function getAgeclassCollection(): array
    {
        return $this->ageclassCollection;
    }
}