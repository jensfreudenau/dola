<?php

namespace App\Http\Controllers\Admin;

use App\Models\Competition;
use App\Models\Organizer;
use App\Repositories\Participator\ParticipatorRepositoryInterface;
use App\Services\ParticipatorService;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreParticipatorsRequest;

class ParticipatorsController extends Controller
{
    protected $participatorRepository;

    public function __construct(ParticipatorRepositoryInterface $participatorRepository)
    {
        $this->participatorRepository = $participatorRepository;
    }

    /**
     * Display a listing of participator.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('participator_access')) {
            return abort(401);        }

        $participators = $this->participatorRepository->all();
        return view('admin.participators.index', compact('participators'));
    }

    public function listing($competitionId)
    {
        if (!Gate::allows('participator_access')) {
            return abort(401);
        }
        $competition = Competition::findOrFail($competitionId);
        return view('admin.participators.list', compact('competition'));
    }

    /**
     * Show the form for creating new participator.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('participator_create')) {
            return abort(401);
        }
        $teams = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        return view('admin.participators.create', compact('teams'));
    }

    /**
     * Store a newly created participator in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreParticipatorsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParticipatorsRequest $request)
    {
        if (!Gate::allows('participator_create')) {
            return abort(401);
        }
        $this->participatorRepository->create($request->all());
        return redirect()->route('admin.participators.index');
    }

    /**
     * Display participator.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('participator_view')) {
            return abort(401);
        }
        $participator =  $this->participatorRepository->find($id);
        return view('admin.participators.show', compact('participator'));
    }

    public function download($id, ParticipatorService $participatorService)
    {
        $competition = Competition::findOrFail($id);
        return $participatorService->sendCsvFile($competition);
    }
}
