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
    /** @var CompetitionRepositoryInterface @ */
    protected $competitionRepository;
    /** @var AdditionalRepositoryInterface @ */
    protected $additionalRepository;
    protected $competitionService;
    protected $ageclassList = array();
    protected $disciplineList = array();
    protected $errorList = array();
    protected $tableStyle = self::TABLE_STYLE;
    protected $tableHeadStyle = self::THEAD_STYLE;
    protected $ignoreAgeclasses = false;
    protected $ignoreDisciplines = false;
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
    public function __construct(
        CompetitionRepositoryInterface $competitionRepository,
        AdditionalRepositoryInterface $additionalRepository,
        AgeclassService $ageclassService,
        DisciplineService $disciplineService
    ) {
        /** @var \App\Repositories\Competition\CompetitionRepository competitionRepository */
        $this->competitionRepository = $competitionRepository;
        /** @var \App\Repositories\Additional\AdditionalRepository additionalRepository */
        $this->additionalRepository = $additionalRepository;
        /** @var  ageclassService */
        $this->ageclassService = $ageclassService;
        /** @var  disciplineService */
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
            $files             = Storage::files('public/'.Config::get('constants.Results').'/'.$season);
            $archives[$season] = DateTimeHelper::listdir_by_date($files);
        }

        return $archives;
    }

    use ParseDataTrait;
    use StringMarkerTrait;

    /**
     * @param $id
     * @param $values
     * @param $season
     */
    public function appendAdditionals($id, $values, $season)
    {
        foreach ($values as $value) {
            Additional::updateOrCreate(
                [
                    'competition_id' => $id,
                    'key' => $value['key'],
                    'value' => $value['value'],
                    'mnemonic' => $season,
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
        $this->ignoreAgeclasses  = $request->has('ignore_ageclasses');
        $this->ignoreDisciplines = $request->has('ignore_disciplines');
        if ($request->has('timetable_1') && !empty($request->timetable_1)) {
            $newTimetable = $this->storeTimetableData($request->timetable_1);
            $request->merge(array('timetable_1' => $newTimetable));
        }
        if (!$competitionId) {
            $competitionId = $this->competitionRepository->create($request->all())->id;
            /** @var Competition $competition */
            $competition = $this->find($competitionId);
        } else {
            /** @var Competition $competition */
            $competition = $this->find($competitionId);
            $competition->update($request->all());
        }
        if ($this->ignoreAgeclasses) {
            $competition->Ageclasses()->sync($request->ageclasses);
        } else {
            $this->ageclassService->syncAgeClasses($competition);
        }
        if ($this->ignoreDisciplines) {
            $competition->Disciplines()->sync($request->disciplines);
        } else {
            $this->disciplineService->syncDisciplines($competition);
        }
        $this->saveAdditionals($request->all(), $competition);
        if (!empty($errorList['ageclassError'])) {
            Log::debug('ageclassError');
        }
        if (!empty($errorList['disciplineError'])) {
            Log::debug('disciplineError');
        }

        return $competitionId;
    }

    /**
     * @param $timetableRaw
     * @param $customAgeclasses
     * @return mixed
     */
    protected function storeTimetableData($timetableRaw)
    {
        $timetable = new TimetableParser();
        $timetable->setTimeTableRaw($timetableRaw);
        $timetable->loadIntoDom();
        $timetable->createTable();
        if (!$this->ignoreAgeclasses) {
            $this->ageclassService->parseAgeclasses($timetable->getHeader());
        }
        if (!$this->ignoreDisciplines) {
            $this->disciplineService->parseDisciplines($timetable->getTableBody());
        }

        return $timetable->getTimeTable();
    }

    public function find($competitionId)
    {
        return $this->competitionRepository->find($competitionId);
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
                    [
                        'id' => $key,
                        'competition_id' => $competition->id,
                    ],
                    [
                        'key' => $keyVal['key'],
                        'value' => $keyVal['value'],
                        'mnemonic' => $competition->season,
                    ]
                );
            }
        }
    }

    /**
     * @param $season
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findBySeason($season)
    {
        $competitions = $this->competitionRepository->order('start_date', 'asc')->where('season', strtolower($season));
        foreach ($competitions as $competition) {
            $competition->ageclasses = $competition->reduceClasses();
        }
        return $competitions;
    }

    public function findByClubId($id)
    {
        return $this->competitionRepository->order('start_date', 'asc')->where('organizer_id', $id);
    }

    public function getSelectFirst()
    {
        return Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy(
            'start_date',
            'asc'
        )->first();
    }

    public function getSelectable()
    {
        return Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy(
            'start_date',
            'asc'
        )->get()->pluck('header', 'id');
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