<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ageclass;
use App\Models\Competition;
use App\Models\Address;
use App\Models\Organizer;
use App\Models\Upload;
use App\Services\DisciplineService;
use App\Traits\FileUploadTrait;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use App\Services\CompetitionService;
use App\Traits\StringMarkerTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Log\Logger;

class CompetitionController extends Controller
{
    protected $competitionRepository;
    protected $competitionService;
    protected $competionsErrorList;
    protected $disciplineService;

    /**
     * CompetitionController constructor.
     * @param CompetitionRepositoryInterface $competitionRepository
     * @param CompetitionService $competitionService
     * @param DisciplineService $disciplineService
     */
    public function __construct(CompetitionRepositoryInterface $competitionRepository, CompetitionService $competitionService, DisciplineService $disciplineService)
    {
        $this->competitionRepository = $competitionRepository;
        $this->competitionService    = $competitionService;
        $this->disciplineService     = $disciplineService;
    }

    public function index()
    {
        $future  = $this->competitionRepository->getFutured();
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
        $disciplines = $this->disciplineService->getSelectedDisciplines();
        $competition = $this->competitionService->find($id);
        $additionals = $this->competitionService->getAdditionals($id);

        return view('admin.competitions.edit', compact('addresses', 'competition', 'organizers', 'additionals', 'ageclasses', 'disciplines'));
    }

    /**
     * Update the given post.
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $this->competitionService->storeData($request, $id);

        return redirect('/admin/competitions/'.$id);
    }

    use FileUploadTrait;

    public function uploader(Request $request, $id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition                = $this->competitionService->find($id);
        $path                       = 'public/'.$request->type.'/'.$competition->season;
        $filename                   = str_replace('-','',$competition->createMysqlFormat( $competition->start_date)).'_'.$competition->id.'_'.mt_rand(5, 15);
        $uploads                    = $this->saveFiles($request, $path, $filename);
        $requests                   = $request->all();
        $requests['competition_id'] = $id;
        $requests['type']           = $request->type;
        $requests['filename']       = $uploads->uploader;
        Upload::create($requests);

        return response()->json(
            $uploads
        );
    }

    public function create()
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $organizers  = $this->competitionService->getOrganizers();
        $competition = '';

        return view('admin.competitions.create', compact('organizers', 'competition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $ignore      = $request->get('ignore_error');
        $competionId = $this->competitionService->storeData($request);
        $errorList   = $this->competitionService->getErrorList();
        $firstError = Arr::first($errorList['disciplineError']);
        if ($firstError != '' && $ignore != 'ignore') {
            $this->competitionService->delete($competionId);
            return Redirect::back()->withInput()->withErrors($errorList['disciplineError']);
        }

        return redirect('/admin/competitions/'.$competionId);
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
        try {
            Storage::delete('public/'.$uploadedFile->type.'/'.$competition->season.'/'.$uploadedFile->filename);
        } catch (Exception $exception) {
            Log::error($exception);
        }
        try {
            $uploadedFile->delete();
        } catch (Exception $exception) {
            Log::error($exception);
        }

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
