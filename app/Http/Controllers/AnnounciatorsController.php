<?php

namespace App\Http\Controllers;

use App\Models\Announciator;
use App\Models\Competition;
use App\Http\Requests;
use App\Mail\EnrolReceived;
use App\Models\Participator;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use App\Services\ParticipatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Session;

class AnnounciatorsController extends Controller
{
    protected $competitionRepository;

    public function __construct(CompetitionRepositoryInterface $competitionRepository)
    {
        $this->competitionRepository = $competitionRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function create($id='')
    {
        if (empty($id)) {
            $competition = Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy('start_date', 'asc')->limit(1)->get();
            $id = $competition[0]->id;
        }
        $competition = Competition::findOrFail($id);

        $disciplines = $competition->disciplines->pluck('shortname', 'id')->toArray();
        $ageclasses = $competition->ageclasses->pluck('shortname', 'id')->toArray();
        $competitionselect = Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy('start_date', 'asc')->get()->pluck('header', 'id');
        return view('front.announciators.create', compact('competition', 'competitionselect', 'disciplines', 'ageclasses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @param ParticipatorService $participatorService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, ParticipatorService $participatorService)
    {

        foreach ($request->vorname as $key => $item) {
            $participators[$key]['prename'] = $item;
        }
        foreach ($request->nachname as $key => $item) {
            $participators[$key]['lastname'] = $item;
        }
        foreach ($request->jahrgang as $key => $item) {
            $participators[$key]['birthyear'] = $item;
        }
        foreach ($request->ageclass as $key => $item) {
            $participators[$key]['ageclass_id'] = $item;
        }
        foreach ($request->discipline as $key => $item) {
            $participators[$key]['discipline_id'] = $item;
        }

        foreach ($request->bestzeit as $key => $item) {
            $participators[$key]['best_time'] = $item;
        }

        $announciator = Announciator::create($request->all());
        foreach ($participators as $participator) {
            $participator['announciator_id'] = $announciator->id;
            Participator::create($participator);
        }
        $competition = $this->competitionRepository->findById($request->competition_id);
        $participatorService->sendCsvFile($announciator->Participator, $competition);

        Mail::send(new EnrolReceived($announciator, $competition));

        $cookie = Cookie::make('announciators_id', $announciator->id);
        return redirect()->action('AnnounciatorsController@listParticipator')->withCookie($cookie);
    }

    public function listParticipator(ParticipatorService $participatorService)
    {
        $announciatorId = Cookie::get('announciators_id', 0);
        if(0 == $announciatorId) {
            return redirect()->action('HomeController@index');
        }

        $announciator = Announciator::findOrFail($announciatorId);
        //$competition = Competition::findOrFail($announciator->competition_id);
        $competition = $this->competitionRepository->findById($announciator->competition_id);
        $participatorService->sendCsvFile($announciator->Participator, $competition);
        return view('front.announciators.list', compact('announciator', 'competition'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $team = Announciator::findOrFail($id);
        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $team = Announciator::findOrFail($id);
        return view('announciators.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $requestData = $request->all();
        $team = Announciator::findOrFail($id);
        $team->update($requestData);
        Session::flash('flash_message', 'Announciators updated!');
        return redirect('announciators');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Annunciator::destroy($id);
        Session::flash('flash_message', 'Announciators deleted!');
        return redirect('announciators');
    }

    public function competitions_select($id, Request $request)
    {
        $competitions = Competition::findOrFail($id);
        $competitions->organizer->name;
        return $competitions;
    }
}
