<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 19.01.18
 * Time: 16:37
 */

namespace App\Services;

use App\Library\Timetable;
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

    /**
     * @param $files
     * @return array
     */
    protected function listdir_by_date($files)
    {
        $list = [];
        foreach ($files as $key => $file) {
            if (basename($file) == 'styles.css') continue;
            if (basename($file) == 'index.html') continue;
            // add the filename, to be sure not to
            // overwrite a array key
            list($filebase, $ending) = explode(".", $file);
            if ($ending != 'html' || $ending != 'pdf' ) continue;
//
            preg_match_all('/[0-9]/', $filebase, $match);
            if (count($match[0]) < 6) continue;
            $six = false;
            if (count($match[0]) == 6) {
                $six = true;
            }
            if (count($match[0]) > 8) {
                $match[0][8] = '';
            }
            $v = implode($match[0]);
            if ($six) {
                $v = '20' . $v;
            }
            $date                                   = new DateTime($v);
            $list[$date->format('Y')][$key]['file'] = $file;
            $list[$date->format('Y')][$key]['date'] = $date->format('d.m.Y');
        }
        return $list;
    }

    use ProofLADVTrait;
    use ParseDataTrait;
    use StringMarkerTrait;

    /**
     * @param $submitData
     * @param bool $ignore
     * @return bool $competitionId
     */
    public function storeData($submitData, $ignore = false)
    {
        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->storeTimetableData($submitData['timetable_1'], false);
            $submitData['timetable_1'] = $this->replaceTableTag($submitData['timetable_1'], $this->tableStyle, $this->tableHeadStyle);
            $this->errorList           = $this->getErrorlists();
        }
        if (!empty($this->errorList['ageclassError']) || !empty($this->errorList['disciplineError'])) {
            if (false == $ignore) {
                return true;
            }
        }
        $competitionId = $this->competitionRepository->create($submitData)->id;
        $this->attachAgeclasses($competitionId);
        $this->attacheDisciplines($competitionId);
        if (!empty($submitData['keyvalue'])) {
            $this->appendAdditionals($competitionId, $submitData['keyvalue'], $submitData['season']);
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
     * @param $timetableCsv
     * @param $customAgeclasses
     * @return mixed
     */
    private function storeTimetableData($timetableCsv, $customAgeclasses)
    {
        $discipline = new \App\Library\Discipline();
        $ageclass   = new \App\Library\Ageclass();
        $timetable  = new Timetable($ageclass, $discipline);
        $timetable->setTimeTable($timetableCsv);
        $timetable->loadIntoDom();
        $timetable->setIgnoreAgeclasses($customAgeclasses);
        $timetable->parsingTable();

        foreach ($timetable->ageclass->getAgeclasses() as $class) {
            $this->proofAgeclassCollection($class);
        }
        foreach ($timetable->discipline->getDisciplines() as $discipline) {
            $this->proofDisciplineCollection($discipline);
        }
        return $timetable->getTimeTable();
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
     * @param $competitionId
     * @param Request $request
     * @return $this|bool
     */
    public function updateData($competitionId, Request $request)
    {
        $submitData = $request->all();
        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->storeTimetableData($submitData['timetable_1'], $request->has('custom_ageclasses'));
            $errorList                 = $this->getErrorlists();
        }
        /** @var Competition $competition */
        $competition = $this->find($competitionId);
        $competition->update($submitData);
        if($request->has('custom_ageclasses')){
            $competition->Ageclasses()->sync($submitData['ageclasses']);
        }
        else {
            $this->syncAgeClasses($competition);
        }
        $this->syncDisciplines($competition);
        $this->saveAdditionals($submitData, $competition);
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

    /**
     * @return mixed
     */
    public function getErrorList()
    {
        return $this->errorList;
    }
}