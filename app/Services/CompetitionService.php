<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 19.01.18
 * Time: 16:37
 */

namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Library\AgeclassCreator;
use App\Library\DisciplineCreator;

use App\Library\TimetableParser;
use App\Models\Additional;
use App\Models\Ageclass;

use App\Traits\ParseDataTrait;
use App\Models\Announciator;
use App\Models\Competition;
use App\Models\Discipline;
use App\Models\Organizer;
use App\Repositories\Additional\AdditionalRepositoryInterface;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use App\Traits\StringMarkerTrait;
use DateTime;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CompetitionService
{
    const TABLE_STYLE = '<table class="table table-sm table-hover">';
    const THEAD_STYLE = '<thead class="thead-inverse">';
    protected $competitionRepository;
    protected $additionalRepository;
    protected $ageclassList   = array();
    protected $disciplineList = array();
    protected $competitionService;
    protected $tableStyle     = '<table class="table table-sm table-hover">';
    protected $tableHeadStyle = '<thead class="thead-inverse">';
    protected $errorList;
    protected $ignoreAgeclasses;
    /**
     * @var AgeclassService
     */
    private $ageclassService;
    /**
     * @var DisciplineService
     */
    private $disciplineService;

    /**
     * CompetitionService constructor.
     * @param CompetitionRepositoryInterface $competitionRepository
     * @param AdditionalRepositoryInterface $additionalRepository
     * @param AgeclassService $ageclassService
     * @param DisciplineService $disciplineService
     */
    public function __construct(CompetitionRepositoryInterface $competitionRepository, AdditionalRepositoryInterface $additionalRepository, AgeclassService $ageclassService, DisciplineService $disciplineService)
    {
        /** @var \App\Repositories\Competition\CompetitionRepository competitionRepository */
        $this->competitionRepository = $competitionRepository;
        /** @var \App\Repositories\Additional\AdditionalRepository additionalRepository */
        $this->additionalRepository = $additionalRepository;
        /** @var \App\Repositories\Additional\AdditionalRepository additionalRepository */
        $this->ageclassService = $ageclassService;
        $this->disciplineService = $disciplineService;
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
            $archives[$season] = DateTimeHelper::listdir_by_date($files);
        }
        return $archives;
    }



    use ParseDataTrait;
    use StringMarkerTrait;

    /**
     * @param $timetableRaw
     * @param $customAgeclasses
     * @return mixed
     */
    private function storeTimetableData($timetableRaw)
    {
        $timetable = new TimetableParser();
        $timetable->setTimeTableRaw($timetableRaw);
        $timetable->loadIntoDom();
        $timetable->createTable();
        if (!$this->ignoreAgeclasses) {
            $this->ageclassService->parseAgeclasses($timetable->getHeader());
        }
        $this->disciplineService->parseDisciplines($timetable->getTableBody());
        $t = $timetable->getTimeTable();
        return $timetable->getTimeTable();
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
     * @param Request $request
     * @param bool $competitionId
     * @return bool $competitionId
     */
    public function storeData(Request $request, $competitionId = false)
    {
        $this->ignoreAgeclasses = $request->has('custom_ageclasses');
        if ($request->has('timetable_1')) {
            $newTimetable = $this->storeTimetableData($request->timetable_1);
            $request->merge(array('timetable_1' => $newTimetable));
            #$errorList                 = $this->getErrorlists();
//            if (!empty($this->errorList['ageclassError']) || !empty($this->errorList['disciplineError'])) {
//                if (false == $request->has('ignore_error')) {
//                    return true;
//                }
//            }
        }
        if(!$competitionId) {
            $competitionId = $this->competitionRepository->create($request->all())->id;
            /** @var Competition $competition */
            $competition = $this->find($competitionId);
        }
        else {
            /** @var Competition $competition */
            $competition = $this->find($competitionId);
            $competition->update($request->all());
        }
        if ($request->has('custom_ageclasses')) {
            $competition->Ageclasses()->sync($request->ageclasses);
        } else {
            $this->ageclassService->syncAgeClasses($competition);
        }
        $this->disciplineService->syncDisciplines($competition);
        $this->saveAdditionals($request->all(), $competition);
        if (!empty($errorList['ageclassError'])) {
            Log::debug('ageclassError');
        }
        if (!empty($errorList['disciplineError'])) {
            Log::debug('disciplineError');
        }
        return true;

    }



    public function find($competition_id)
    {
        return $this->competitionRepository->find($competition_id);
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
     *  $submitData = $request->all();
    $this->ignoreAgeclasses = $request->has('custom_ageclasses');
    if ($request->has('timetable_1')) {
    $submitData['timetable_1'] = $this->storeTimetableData($request->timetable_1);
    #$errorList                 = $this->getErrorlists();
    }

$competition = $this->find($competitionId);
$competition->update($submitData);
if ($request->has('custom_ageclasses')) {
$competition->Ageclasses()->sync($submitData['ageclasses']);
} else {
    $this->ageclassService->syncAgeClasses($competition);
}
$this->disciplineService->syncDisciplines($competition);
$this->saveAdditionals($submitData, $competition);
if (!empty($errorList['ageclassError'])) {
    Log::debug('ageclassError');
}
if (!empty($errorList['disciplineError'])) {
    Log::debug('disciplineError');
}
return true;
     */
    /**
     * @param Request $request
     * @return bool
     */
    protected function createData(Request $request)
    {
        $this->ignoreAgeclasses = $request->has('custom_ageclasses');
        if ($request->has('timetable_1')) {
            $request->timetable_1 = $this->storeTimetableData($request->timetable_1);
            #$errorList                 = $this->getErrorlists();
//            if (!empty($this->errorList['ageclassError']) || !empty($this->errorList['disciplineError'])) {
//                if (false == $request->has('ignore_error')) {
//                    return true;
//                }
//            }
        }
        $competitionId = $this->competitionRepository->create($request->all())->id;
        $this->ageclassService->syncAgeClasses($competition);
        $this->disciplineService->syncDisciplines($competition);

        if ($request->has('keyvalue')) {
            $this->appendAdditionals($competitionId, $request->keyvalue, $request->season);
        }
        if (!empty($errorList['ageclassError'])) {
            Log::info('ageclassError');
        }
        if (!empty($errorList['disciplineError'])) {
            Log::info('disciplineError');
        }
        return $competitionId;
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

    /**
     * @return mixed
     */
    public function getErrorList()
    {
        return $this->errorList;
    }
}