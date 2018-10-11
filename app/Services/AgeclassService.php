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
    protected $ageclassCollection = array();
    protected $ageclassCollectionError = array();
    protected $domAgeclasses;
    protected $classes = [];
    /** @var AgeclassRepositoryInterface */
    protected $ageclassRepository;

    public function __construct(AgeclassRepositoryInterface $ageclassRepository)
    {
        $this->ageclassRepository = $ageclassRepository;
    }

    public function attachAgeclasses($id)
    {
        foreach ($this->getProofedAgeclasses() as $key => $class) {
            $ageClass = Ageclass::where('ladv', '=', $key)->first();
            $ageClass->competitions()->attach($id);
        }
    }

    public function getProofedAgeclasses()
    {
        return $this->ageclassCollection;
    }

//    public function syncAgeClasses($competition)
//    {
//        $ageclassIds = [];
//        foreach ($this->getProofedAgeclasses() as $ageclassKey => $ageclass) {
//            $data          = Ageclass::where('ladv', '=', $ageclassKey)->select('id')->get()->toArray();
//            $ageclassIds[] = $data[0]['id'];
//        }
//        $competition->Ageclasses()->sync($ageclassIds);
//    }

    public function loadAgeclasses(): array
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



    public function getAgeclassCollectionError(): array
    {
        return $this->ageclassCollectionError;
    }



    protected function getPluck()
    {
        return Ageclass::orderBy('name', 'asc')->pluck('shortname', 'id')->toArray();
    }

    public function getAgeclassesPluck($competition)
    {
        if ($competition === '' || 'cross' === $competition->season) {
            return $this->getPluck();
        }

        return $competition->ageclasses->pluck('shortname', 'id')->toArray();
    }

    public function fillUpAgeclassIds($parsedAgeclassesFromTable): array
    {
        $ageclassIds = [];
        foreach ($parsedAgeclassesFromTable as $key => $ageclass) {
            $ageclassIds[] = $ageclass['id'];
        }
        return $ageclassIds;
    }
}