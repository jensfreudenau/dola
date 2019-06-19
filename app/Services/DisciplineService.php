<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 21.03.18
 * Time: 14:55
 */

namespace App\Services;

use App\Helpers\Str;
use App\Models\Discipline;
use DOMDocument;
use function GuzzleHttp\Promise\exception_for;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;

/**
 * @property DOMDocument dom
 */
class DisciplineService
{
    protected $disciplineCollection = array();
    protected $disciplineCollectionError = array();
    protected $domDisciplines;
    protected $disciplines;
    protected $dom;

    public function __construct()
    {
    }

    /**
     * @param $id
     */
//    public function attacheDisciplines($id)
//    {
//        foreach ($this->getProofedDisciplines() as $key => $class) {
//            $discipline = Discipline::where('ladv', '=', $key)->first();
//            $discipline->competitions()->attach($id);
//        }
//    }

    /**
     * @return array
     */
    public function getDisciplineCollectionError(): array
    {
        return $this->disciplineCollectionError;
    }

    public function getErrorlists()
    {
        return ['disciplineError' => $this->disciplineCollectionError];
    }

    public function fillUpDisciplineIds($parsedDisciplinesFromTable): array
    {
        $disciplineIds = [];
        if (is_array($parsedDisciplinesFromTable)) {
            foreach ($parsedDisciplinesFromTable as $key => $discipline) {
                $disciplineIds[] = $discipline['id'];
            }
        }
        return $disciplineIds;
    }

    public function getDisciplines()
    {
        return $this->disciplines;
    }

    public function getPluck($competition)
    {
        return $competition->disciplines->pluck('shortname', 'id')->toArray();
    }

    public function getPluckFormat($competition)
    {
        return $competition->disciplines->pluck('format', 'id')->toArray();
    }

    public function getSelectedDisciplines(): array
    {
        return Discipline::pluck('shortname', 'id')->toArray();
    }

    public function getIdByShortname($shortname)
    {
        return Discipline::where('shortname', '=', $shortname)->value('id');
    }

    public function createJson($competition)
    {
        $disciplinesJson = '{';
        foreach ($competition->disciplines as $disciplines) {
            $disciplinesJson .= '"'.$disciplines->shortname .'":"'. $disciplines->id .'",';
        }
        $disciplinesJson .= '}';
        return $disciplinesJson;
    }

    public function createPersonalBestJson($competition)
    {
        $personalBestFormatJson = '{' ;
        foreach ($competition->disciplines as $disciplines) {
            $personalBestFormatJson .= '"'.$disciplines->shortname .'":"'. $disciplines->format .'",';
        }
        $personalBestFormatJson .= '}' ;
        return $personalBestFormatJson;
    }
}