<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ageclass;
use App\Models\Competition;
use App\Models\Address;

use App\Models\Organizer;
use App\Models\Upload;

use App\Traits\FileUploadTrait;

use App\Http\Requests\Admin\StoreCompetitionsRequest;
use App\Http\Requests\Admin\UpdateCompetitionsRequest;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use App\Services\CompetitionService;
use App\Traits\StringMarkerTrait;
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
    use StringMarkerTrait;
    public function show($id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition              = $this->competitionService->find($id);
        $additionals              = $this->competitionService->getAdditionals($id);
        $ageclasses               = $competition->Ageclasses;
        $disciplines              = $competition->Disciplines;
        $competition->timetable_1 = $this->markFounded($competition->timetable_1, $ageclasses);
        $competition->timetable_1 = $this->markFounded($competition->timetable_1, $disciplines);
        $announciators            = $this->competitionService->getAnnounciators($id);
        return view('admin.competitions.show', compact('competition', 'additionals', 'disciplines', 'announciators'));
    }

    public function edit($id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $addresses   = Address::get()->pluck('name', 'id');
        $ageclasses  = Ageclass::get()->pluck('shortname', 'id')->toArray();
        $organizers  = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        $disciplines = $this->competitionService->getSelectedDisciplines();
        $competition = $this->competitionService->find($id);
        $additionals = $this->competitionService->getAdditionals($id);

        $season      = $this->competitionService->getActiveSeason($competition->season);
        $register    = $this->competitionService->getActiveRegister($competition->register);
        $onlyList    = $this->competitionService->getActiveListed($competition->only_list);
        return view('admin.competitions.edit', compact('addresses', 'competition', 'organizers', 'season', 'additionals', 'register', 'onlyList', 'ageclassList', 'ageclasses', 'disciplines'));
    }

    /**
     * Update the given post.
     * @param UpdateCompetitionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateCompetitionsRequest $request, $id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $this->competitionService->updateData($id, $request->all());
        return redirect('/admin/competitions/' . $id);
    }

    use FileUploadTrait;
    public function uploader(Request $request, $id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition                = $this->competitionService->find($id);
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
        $organizers           = $this->competitionService->getOrganizers();
        $competition          = '';
        $register['external'] = '';
        $register['internal'] = 'active';
        $onlyList['list']     = '';
        $onlyList['not_list'] = 'active';
        $season['track']      = 'active';
        $season['indoor']     = '';
        $season['cross']      = '';
        return view('admin.competitions.create', compact('organizers', 'competition', 'season', 'additionals', 'register', 'onlyList'));
    }



    public function store(StoreCompetitionsRequest $request)
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $competionId = $this->competitionService->storeData($request->all());
        return redirect('/admin/competitions/' . $competionId);
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
        $competition  = $this->competitionService->find($uploadedFile->competition_id);
        Storage::delete('public/' . $uploadedFile->type . '/' . $competition->season . '/' . $uploadedFile->filename);
        $uploadedFile->delete();
        return redirect()->route('admin.competitions.edit', $competition->id);
    }

    /**
     * Delete all selected Comps at once.
     *
     * @param Request $request
     * @return void
     * @throws \Exception
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
