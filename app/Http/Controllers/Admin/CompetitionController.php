<?php

namespace App\Http\Controllers\Admin;

use App\Models\Additional;
use App\Models\Ageclass;
use App\Models\Announciator;
use App\Models\Competition;
use App\Models\Address;
use App\Models\Discipline;
use App\Models\Organizer;
use App\Models\Upload;
use App\Http\Controllers\Traits\ProofLADVTrait;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Controllers\Traits\ParseDataTrait;
use App\Http\Requests\Admin\StoreCompetitionsRequest;
use App\Http\Requests\Admin\UpdateCompetitionsRequest;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use App\Services\CompetitionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    protected $competitionRepository;
    protected $competitionService;
    protected $competionsErrorList;

    /**
     * CompetitionController constructor.
     * @param CompetitionRepositoryInterface $competitionRepository
     * @param CompetitionService $competitionService
     */
    public function __construct(CompetitionRepositoryInterface $competitionRepository, CompetitionService $competitionService)
    {
        $this->competitionRepository = $competitionRepository;
        $this->competitionService    = $competitionService;
    }

    public function index()
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $future = $this->competitionRepository->getFutured();
        $elapsed = $this->competitionRepository->getElapsed();
        return view('admin.competitions.index', compact('future', 'elapsed'));
    }

    use ParseDataTrait;

    public function show($id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition              = $this->competitionRepository->findById($id);
        $additionals              = $this->competitionService->getAdditionals($id);
        $ageclasses               = $competition->Ageclasses;
        $disciplines              = $competition->Disciplines;
        $competition->timetable_1 = $this->markFounded($competition->timetable_1, $ageclasses);
        $competition->timetable_1 = $this->markFounded($competition->timetable_1, $disciplines);
        $announciators            = Announciator::where('competition_id', '=', $id)->get();
        return view('admin.competitions.show', compact('competition', 'additionals', 'disciplines', 'announciators'));
    }

    public function edit($id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition = $this->competitionRepository->findById($id);
        $addresses   = Address::get()->pluck('name', 'id');
        $ageclasses  = Ageclass::get()->pluck('shortname', 'id')->toArray();
        $organizers  = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        $additionals = $this->competitionService->getAdditionals($id);

        $disciplines = Discipline::pluck('shortname', 'id')->toArray();
        $season      = $this->competitionRepository->getActiveSeason($competition);
        $register    = $this->competitionRepository->getActiveRegister($competition);
        $onlyList    = $this->competitionRepository->getActiveListed($competition);
        return view('admin.competitions.edit', compact('addresses', 'competition', 'organizers', 'season', 'additionals', 'register', 'onlyList', 'ageclassList', 'ageclasses', 'disciplines'));
    }

    /**
     * Update the given post.
     * @param UpdateCompetitionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    use FileUploadTrait;
    use ParseDataTrait;
    use ProofLADVTrait;

    public function update(UpdateCompetitionsRequest $request, $id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition          = $this->competitionRepository->findById($id);
        $submitData           = $request->all();
        $this->competionsList = [];
        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->parsingTable($submitData['timetable_1']);
        }
        $competition->update($submitData);
        if (!empty($submitData['keyvalue'])) {
            foreach ($submitData['keyvalue'] as $key => $keyVal) {
                Additional::updateOrCreate(
                    ['id' => $key,
                     'competition_id' => $competition->id],
                    ['key' => $keyVal['key'],
                     'value' => $keyVal['value'],
                     'mnemonic' => $competition->season,
                    ]
                );
            }
        }
        $this->competionsErrorList  = array();
        $this->disciplineListError  = array();
        $this->ageclassErrorList    = array();
        $this->ageclassCollection   = array();
        $this->disciplineCollection = array();
        #TODO move to Models
        foreach ($this->disciplineList as $discipline) {
            $this->proofDiscipline($discipline);
        }
        foreach ($this->disciplineListError as $key => $disciplineError) {
            #[$discipline,] = explode(' ', $disciplineError); //php7
            list($discipline, $secondArg) = explode(' ', $disciplineError);
            if (true == $this->proofDiscipline($discipline)) {
                unset($this->disciplineError[$key]);
            }
        }
        foreach ($this->ageclassList as $parsedClass) {
            $this->proofAgeclasses($parsedClass);
        }
        if ($this->ageclassErrorList) {
            return back()->withInput()->withErrors($this->ageclassErrorList);
        }
        $ids = array();
        foreach ($this->ageclassCollection as $ageclassKey => $ageclass) {
            $data  = Ageclass::where('ladv', '=', $ageclassKey)->select('id')->get()->toArray();
            $ids[] = $data[0]['id'];
        }
        $competition->ageclasses()->sync($ids);
        $ids = array();
        foreach ($this->disciplineCollection as $disciplineKey => $discipline) {
            $data  = Discipline::where('ladv', '=', $disciplineKey)->select('id')->get()->toArray();
            $ids[] = $data[0]['id'];
        }
        $competition->disciplines()->sync($ids);
        return redirect('/admin/competitions/' . $id);
    }

    use FileUploadTrait;

    public function uploader(Request $request, $id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition                = $this->competitionRepository->findById($id);
        $path                       = 'public/' . $request->type . '/' . $competition->season;
        $uploads                    = $this->saveFiles($request, $path);
        $requests                   = $request->all();
        $requests['competition_id'] = $id;
        $requests['type']           = $request->type;
        $requests['filename']       = $uploads->uploader;
        Upload::create($requests);
        return 'done';
    }

    public function create()
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $addresses            = Address::get()->pluck('name', 'id')->prepend('Please select', '');
        $organizers           = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        $competition          = '';
        $register['external'] = '';
        $register['internal'] = '';
        $onlyList['list']     = '';
        $onlyList['not_list'] = '';
        $season['track']      = '';
        $season['indoor']     = '';
        $season['cross']      = '';
        return view('admin.competitions.create', compact('addresses', 'organizers', 'competition', 'season', 'additionals', 'register', 'onlyList'));
    }

    use ParseDataTrait;
    use FileUploadTrait;

    public function store(StoreCompetitionsRequest $request)
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        #TODO move to Models
        $this->ageclassCollection   = array();
        $this->disciplineCollection = array();
        $submitData                 = $request->all();
        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->parsingTable($submitData['timetable_1']);
        }
        foreach ($this->ageclassList as $class) {
            $this->proofAgeclasses($class);
        }
        foreach ($this->disciplineList as $discipline) {
            $this->proofDiscipline($discipline);
        }
        $id = $this->competitionRepository->create($submitData)->id;
        foreach ($this->ageclassCollection as $key => $class) {
            $ageClass = Ageclass::where('ladv', '=', $key)->first();
            $ageClass->competitions()->attach($id);
        }
        foreach ($this->disciplineCollection as $key => $class) {
            $discipline = Discipline::where('ladv', '=', $key)->first();
            $discipline->competitions()->attach($id);
        }
        if (!empty($submitData['keyvalue'])) {
            foreach ($submitData['keyvalue'] as $keyval) {
                $keyval['external_id'] = $id;
                $keyval['mnemonic']    = $request->season;
                Additional::create($keyval);
            }
        }
        return redirect('/admin/competitions/' . $id);
    }

    /**
     * Remove Compe from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!Gate::allows('competition_delete')) {
            return abort(401);
        }
       $this->competitionRepository->delete($id);

        return redirect()->route('admin.competitions.index');
    }

    public function delete_file($id)
    {
        if (!Gate::allows('competition_delete_file')) {
            return abort(401);
        }
        $uploadedFile = Upload::findOrFail($id);
        $competition  = $this->competitionRepository->findById($uploadedFile->competition_id);
        Storage::delete('public/' . $uploadedFile->type . '/' . $competition->season . '/' . $uploadedFile->filename);
        $uploadedFile->delete();
        return redirect()->route('admin.competitions.edit', $competition->id);
    }

    /**
     * Delete all selected Comps at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('competition_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Competition::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
