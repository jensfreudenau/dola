<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 19.01.18
 * Time: 16:37
 */

namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Helpers\Utils;
use App\Library\AgeclassParser;
use App\Library\DisciplineParser;
use App\Library\TimetableParser;
use App\Models\Additional;
use App\Models\Announciator;
use App\Models\Competition;
use App\Models\Discipline;
use App\Models\Organizer;
use App\Repositories\Additional\AdditionalRepositoryInterface;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use App\Traits\StringMarkerTrait;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Storage;

class CompetitionService
{
    const TABLE_STYLE = '<table class="table table-sm table-hover">';
    const THEAD_STYLE = '<thead class="thead-inverse">';
    /** @var CompetitionRepositoryInterface @ */
    protected $competitionRepository;
    /** @var AdditionalRepositoryInterface @ */
    protected $additionalRepository;
    /** @var  Competition */
    protected $competition;
    protected $competitionService;
    protected $ageclassList = array();
    protected $disciplineList = array();
    protected $errorList = array();
    protected $tableStyle = self::TABLE_STYLE;
    protected $tableHeadStyle = self::THEAD_STYLE;
    protected $ignoreAgeclasses = false;
    protected $ignoreDisciplines = false;
    protected $timetableParser;
    protected $ageclassParser;
    protected $disciplineParser;
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
     * @param TimetableParser $timetableParser
     * @param AgeclassParser $ageclassParser
     * @param DisciplineParser $disciplineParser
     */
    public function __construct(
        CompetitionRepositoryInterface $competitionRepository,
        AdditionalRepositoryInterface $additionalRepository,
        AgeclassService $ageclassService,
        DisciplineService $disciplineService,
        TimetableParser $timetableParser,
        AgeclassParser $ageclassParser,
        DisciplineParser $disciplineParser
    ) {
        /** @var \App\Repositories\Competition\CompetitionRepository competitionRepository */
        $this->competitionRepository = $competitionRepository;
        /** @var \App\Repositories\Additional\AdditionalRepository additionalRepository */
        $this->additionalRepository = $additionalRepository;
        /** @var  ageclassService */
        $this->ageclassService = $ageclassService;
        /** @var  disciplineService */
        $this->disciplineService = $disciplineService;
        /** @var timetableParser */
        $this->timetableParser  = $timetableParser;
        $this->ageclassParser   = $ageclassParser;
        $this->disciplineParser = $disciplineParser;
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

    public function getArchive() :array
    {
        $archives = array();
        foreach ($this->competitionRepository->seasons as $season) {
            $files             = Storage::files('public/'.Config::get('constants.Results').'/'.$season);
            $season = Utils::replaceSeasonName($season);
            $archives[$season] = DateTimeHelper::listdir_by_date($files);
        }
        if (date('Y') >= 2018) {
            $files        = [];
            $competitions = Competition::onlyTrashed()
                    ->where('only_list', 0)
                    ->orderBy('start_date')
                    ->get();
            foreach ($competitions as $competition) {
                if ($competition->uploads !== '') {
                    foreach ($competition->uploads as $upload) {
                        if ($upload->type == 'resultsets') {
                            $uploadedFile['file'] = 'public/'.Config::get('constants.Results').'/'.$competition->season.'/'.$upload->filename;
                            $uploadedFile['date'] = $competition->start_date;
                            $files[] = $uploadedFile;

                        }
                    }
                }

                $year = Carbon::parse($competition->start_date)->format('Y');
                $archives[$competition->season][$year] = $files;
            }
        }

        return $archives;
    }

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
        $timetable = '';
        if(trim($request->timetable_1) !== ''){
            $timetable = $this->extractDataFromTimetable($request);
        }
        $request->merge(array('timetable_1' => $timetable));
        $competitionId = $this->storeCompetition($request->all(), $competitionId);
        $this->storeAgeclasses($request->ageclasses, $request->has('ignore_ageclasses'));
        $this->storeDisciplines($request->disciplines, $request->has('ignore_disciplines'));
        $this->storeAdditionals($request->all());

        return $competitionId;
    }

    /**
     * @param $request
     * @return mixed
     */
    protected function extractDataFromTimetable($request)
    {
        if ($request->has('timetable_1') && !empty($request->timetable_1)) {
            $this->timetableParser->proceed($request->timetable_1);
            if(!$request->has('ignore_ageclasses')){
                $this->ageclassParser->proceed($this->timetableParser->getHeader());
            }
            if(!$request->has('ignore_disciplines')){
                $this->disciplineParser->proceed($this->timetableParser->getTableBody());
            }
            $this->errorList['disciplineError'] = $this->disciplineParser->getDisciplineCollectionError();
        }
        return $this->timetableParser->getTimeTable();
    }

    public function find($competitionId)
    {
        return $this->competitionRepository->find($competitionId);
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

    protected function storeAgeclasses($ageclassIds, $ignoreAgeclassesFromTable): void
    {
        if (!$ignoreAgeclassesFromTable) {
            $ageclassIds = $this->ageclassService->fillUpAgeclassIds($this->ageclassParser->getAgeclasses());
        }

        $this->competition->Ageclasses()->sync($ageclassIds);
    }

    protected function storeDisciplines($disciplineIds, $ignoreDisciplinesFromTable): void
    {
        if (!$ignoreDisciplinesFromTable) {
            $disciplineIds = $this->disciplineService->fillUpDisciplineIds($this->disciplineParser->getDisciplines());
        }
        $this->competition->Disciplines()->sync($disciplineIds);
    }

    /**
     * @param $submitData
     */
    protected function storeAdditionals($submitData): void
    {
        if (!empty($submitData['keyvalue'])) {
            foreach ($submitData['keyvalue'] as $key => $keyVal) {
                Additional::updateOrCreate(
                    [
                        'id'             => $key,
                        'competition_id' => $this->competition->id,
                    ],
                    [
                        'key'      => $keyVal['key'],
                        'value'    => $keyVal['value'],
                        'mnemonic' => $this->competition->season,
                    ]
                );
            }
        }
    }

    public function delete($id) {
        $this->competitionRepository->delete($id);
    }

    protected function storeCompetition($data, $competitionId = null)
    {
        if (!$competitionId) {
            $competitionId = $this->competitionRepository->create($data)->id;
            /** @var Competition $competition */
            $this->competition = $this->find($competitionId);
        } else {
            /** @var Competition $competition */
            $this->competition = $this->find($competitionId);
            $this->competition->update($data);
        }
        return $competitionId;
    }
}