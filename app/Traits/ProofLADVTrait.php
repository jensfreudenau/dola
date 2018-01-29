<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 04.12.17
 * Time: 18:18
 */

namespace App\Traits;

use App\Models\Ageclass;
use App\Models\Discipline;

trait ProofLADVTrait
{
    protected $ageclassCollection        = array();
    protected $ageclassCollectionError   = array();
    protected $disciplineCollection      = array();
    protected $disciplineCollectionError = array();



    protected function proofDisciplineCollection($disciplineStr)
    {
        $discipline = Discipline::where('shortname', '=', $disciplineStr)
                                ->orWhere('ladv', '=', $disciplineStr)
                                ->orWhere('name', '=', $disciplineStr)
                                ->orWhere('rieping', '=', $disciplineStr)
                                ->select('ladv', 'shortname')->first();
        if (!$discipline) {
            $this->disciplineCollectionError[] = $disciplineStr;
        } else {
            $this->disciplineCollection[$discipline->ladv] = [$discipline->shortname, $disciplineStr];
        }
    }

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

    public function getErrorlists()
    {
        return ['ageclassError' => $this->ageclassCollectionError, 'disciplineError' => $this->disciplineCollectionError];
    }
    /**
     * @return array
     */
    public function getProofedAgeclasses()
    {
        return $this->ageclassCollection;
    }

    /**
     * @return array
     */
    public function getProofedDisciplines()
    {
        return $this->disciplineCollection;
    }

    /**
     * @return array
     */
    public function getDisciplineCollectionError(): array
    {
        return $this->disciplineCollectionError;
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
    public function getDisciplineCollection(): array
    {
        return $this->disciplineCollection;
    }

    /**
     * @return array
     */
    public function getAgeclassCollection(): array
    {
        return $this->ageclassCollection;
    }
}