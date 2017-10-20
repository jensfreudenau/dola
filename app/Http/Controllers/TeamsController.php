<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mail\EnrolReceived;
use App\ParticipatorTeam;
use App\Participator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;

class TeamsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $competition = '';
        if (!empty($id)) {
            $competition = Competition::findOrFail($id);
        }
        $competitionselect = Competition::where('submit_date', '>=', date('Y-m-d'))->get()->pluck('header', 'id');
        return view('front.teams.create', compact('competition', 'competitionselect'));
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
        foreach ($request->vorname as $key => $item) {
            $participators[$key]['prename'] = $item;
        }
        foreach ($request->nachname as $key => $item) {
            $participators[$key]['lastname'] = $item;
        }
        foreach ($request->jahrgang as $key => $item) {
            $participators[$key]['birthyear'] = $item;
        }
        foreach ($request->altersklasse as $key => $item) {
            $participators[$key]['age_group'] = $item;
        }
        foreach ($request->wettkampf as $key => $item) {
            $participators[$key]['discipline'] = $item;
        }
        foreach ($request->bestzeit as $key => $item) {
            $participators[$key]['best_time'] = $item;
        }


        $participatorTeam = ParticipatorTeam::create($request->all());
        foreach ($participators as $participator) {
            $participator['participator_team_id'] = $participatorTeam->id;
            Participator::create($participator);
        }
        $competition = Competition::findOrFail($request->competition_id);
   
     
        return redirect('teams/list_participator/'.$participatorTeam->id);
    }

    public function listParticipator($id)
    {
        $participatorTeam = ParticipatorTeam::findOrFail($id);
        $competition = Competition::findOrFail($participatorTeam->competition_id);
        Mail::to('jens@freude-now.de')->send(new EnrolReceived($participatorTeam, $competition));
        return view('front.teams.list', compact('participatorTeam', 'competition'));
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
        $team = ParticipatorTeam::findOrFail($id);
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
        $team = ParticipatorTeam::findOrFail($id);
        return view('teams.edit', compact('team'));
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
        $team = ParticipatorTeam::findOrFail($id);
        $team->update($requestData);
        Session::flash('flash_message', 'ParticipatorTeams updated!');
        return redirect('teams');
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
        ParticipatorTeam::destroy($id);
        Session::flash('flash_message', 'ParticipatorTeams deleted!');
        return redirect('teams');
    }

    public function competitions_select($id, Request $request)
    {
        $competitions = Competition::findOrFail($id);
        $competitions->team->name;
        return $competitions;
    }
}
