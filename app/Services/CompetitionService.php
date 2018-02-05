<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 19.01.18
 * Time: 16:37
 */

namespace App\Services;

use App\Models\Additional;
use App\Models\Ageclass;
use App\Traits\ProofLADVTrait;
use App\Traits\ParseDataTrait;
use App\Models\Announciator;
use App\Models\Competition;
use App\Models\Discipline;
use App\Models\Organizer;
use App\Repositories\Additional\AdditionalRepositoryInterface;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompetitionService
{
    protected $competitionRepository;
    protected $additionalRepository;
    protected $ageclassList   = array();
    protected $disciplineList = array();
    protected $competitionService;

    public function __construct(CompetitionRepositoryInterface $competitionRepository, AdditionalRepositoryInterface $additionalRepository)
    {
        $this->competitionRepository = $competitionRepository;
        $this->additionalRepository  = $additionalRepository;
    }

    /**
     * @param $competitionId
     * @return mixed
     */
    public function getAdditionals($competitionId)
    {
        $additionals = $this->additionalRepository->where('competition_id', $competitionId);
        if ($additionals) {
            return $additionals->get();
        }
        return false;
    }

    public function getArchive()
    {
        $archives = array();
        foreach ($this->competitionRepository->seasons as $season) {
            $files             = Storage::files('public/' . Config::get('constants.Results') . '/' . $season);
            $archives[$season] = $this->listdir_by_date($files);
        }
        return $archives;
    }

    use ProofLADVTrait;
    use ParseDataTrait;

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
     * @param $id
     */
    public function attacheDisciplines($id)
    {
        foreach ($this->getProofedDisciplines() as $key => $class) {
            $discipline = Discipline::where('ladv', '=', $key)->first();
            $discipline->competitions()->attach($id);
        }
    }

    /**
     * @param $submitData
     * @return $this
     */
    public function storeData($submitData)
    {
        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->storeTimetableData($submitData['timetable_1']);
            $errorList                 = $this->getErrorlists();
        }
        $competitionId = $this->competitionRepository->create($submitData)->id;
        $this->attachAgeclasses($competitionId);
        $this->attacheDisciplines($competitionId);
        if (!empty($submitData['keyvalue'])) {
            $this->appendAdditionals($competitionId, $submitData['keyvalue'], $submitData['season']);
        }
        if (!empty($errorList['ageclassError'])) {
            Log::info('ageclassError');
//            Log::info($errorList['ageclassError']));
//            return back()->withInput()->withErrors($errorList['ageclassError']);
        }
        if (!empty($errorList['disciplineError'])) {
            Log::info('disciplineError');
//            Log::info(($errorList['disciplineError']));
//            return back()->withInput()->withErrors($errorList['disciplineError']);
        }
        return $competitionId;
    }

    /**
     * @param $competitionId
     * @param $submitData
     * @return $this|bool
     */
    public function updateData($competitionId, $submitData)
    {

        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->storeTimetableData($submitData['timetable_1']);
            $errorList                 = $this->getErrorlists();
        }
        $competition = $this->find($competitionId);
        $competition->update($submitData);
        $this->syncAgeClasses($competition);
        $this->syncDisciplines($competition);
        $this->saveAdditionals($submitData, $competition);
        if (!empty($errorList['ageclassError'])) {
            Log::debug('ageclassError');
//            Log::debug(dump($errorList['ageclassError']));
//            return back()->withInput()->withErrors($errorList['ageclassError']);
        }
        if (!empty($errorList['disciplineError'])) {
            Log::debug('disciplineError');
//            Log::debug(dump($errorList['disciplineError']));
//            return back()->withInput()->withErrors($errorList['disciplineError']);
        }
        return true;
    }

    public function find($competition_id)
    {
        return $this->competitionRepository->find($competition_id);
    }

    /**
     * @param $id
     * @param $values
     * @param $season
     */
    public function appendAdditionals($id, $values, $season)
    {
        foreach ($values as $value) {
            Additional::updateOrCreate(
                ['competition_id' => $id,
                 'key'            => $value['key'],
                 'value'          => $value['value'],
                 'mnemonic'       => $season,
                ]
            );
        }
    }

    /**
     * @param $submitData
     * @param Competition $competition
     */
    public function saveAdditionals($submitData, Competition $competition)
    {
        if (!empty($submitData['keyvalue'])) {
            foreach ($submitData['keyvalue'] as $key => $keyVal) {
                Additional::updateOrCreate(
                    ['id'             => $key,
                     'competition_id' => $competition->id],
                    ['key'      => $keyVal['key'],
                     'value'    => $keyVal['value'],
                     'mnemonic' => $competition->season,
                    ]
                );
            }
        }
    }

    /**
     * @param $registerTyp
     * @return Competition
     */
    public function getActiveRegister($registerTyp)
    {
        if ($registerTyp) {
            $register['external'] = 'active';
            $register['internal'] = '';
        } else {
            $register['internal'] = 'active';
            $register['external'] = '';
        }
        return $register;
    }

    /**
     * @param $onlyListed
     * @return Competition
     */
    public function getActiveListed($onlyListed)
    {
        if ($onlyListed) {
            $onlyList['list']     = 'active';
            $onlyList['not_list'] = '';
        } else {
            $onlyList['not_list'] = 'active';
            $onlyList['list']     = '';
        }
        return $onlyList;
    }

    /**
     * @param $seasonTyp
     * @return Competition
     */
    public function getActiveSeason($seasonTyp)
    {
        $season['track']  = $seasonTyp == 'bahn' ? 'active' : '';
        $season['indoor'] = $seasonTyp == 'halle' ? 'active' : '';
        $season['cross']  = $seasonTyp == 'cross' ? 'active' : '';
        return $season;
    }

    /**
     * @param $season
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findBySeason($season)
    {
        return $this->competitionRepository->order('start_date', 'asc')->where('season', strtolower($season));
    }

    public function findByClubId($id)
    {
        return $this->competitionRepository->order('start_date', 'asc')->where('organizer_id', $id);
    }

    public function getSelectFirst()
    {
        return Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy('start_date', 'asc')->limit(1)->get();
    }

    public function getSelectable()
    {
        return Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy('start_date', 'asc')->get()->pluck('header', 'id');
    }

    public function getAnnounciators($id)
    {
        return Announciator::where('competition_id', '=', $id)->get();
    }

    public function getSelectedDisciplines()
    {
        return Discipline::pluck('shortname', 'id')->toArray();
    }

    public function getOrganizers()
    {
        return Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
    }

    private function storeTimetableData($timetable)
    {
        $this->createDomObject($timetable);
        $this->parsingTable();
        $timetable = $this->getParsedTable();
        $this->searchAgeclasses();
        $this->searchDisciplines();
        foreach ($this->getAgeclassesFromTable() as $class) {
            $this->proofAgeclassCollection($class);
        }
        foreach ($this->getDisciplinesFromTable() as $discipline) {
            $this->proofDisciplineCollection($discipline);
        }
        return $timetable;
    }

    private function syncAgeClasses($competition)
    {
        $ageclassIds = [];
        foreach ($this->getProofedAgeclasses() as $ageclassKey => $ageclass) {
            $data          = Ageclass::where('ladv', '=', $ageclassKey)->select('id')->get()->toArray();
            $ageclassIds[] = $data[0]['id'];
        }
        $competition->Ageclasses()->sync($ageclassIds);
    }

    private function syncDisciplines($competition)
    {
        $disciplineIds = [];
        foreach ($this->getProofedDisciplines() as $disciplineKey => $discipline) {
            $data            = Discipline::where('ladv', '=', $disciplineKey)->select('id')->get()->toArray();
            $disciplineIds[] = $data[0]['id'];
        }
        $competition->disciplines()->sync($disciplineIds);
    }
}