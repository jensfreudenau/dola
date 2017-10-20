<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use App\Address;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreCompetitionsRequest;
use App\Http\Requests\Admin\UpdateCompetitionsRequest;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{

    public function index()
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competitions = Competition::all();
        return view('admin.competitions.index', compact('competitions'));
    }

    public function show($id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition = Competition::findOrFail($id);
        return view('admin.competitions.show', compact('competition'));
    }

    public function edit($id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition = Competition::findOrFail($id);
        $addresses   = Address::get()->pluck('name', 'id');
        $teams       = Team::get()->pluck('name', 'id')->prepend('Please select', '');
        $track = '';
        $cross = '';
        $indoor = '';
        if($competition->season == 'bahn') {
            $track = 'active';
        }
        if($competition->season == 'cross') {
            $cross = 'active';
        }
        if($competition->season == 'halle') {
            $indoor = 'active';
        }
        return view('admin.competitions.update', compact('addresses',  'competition', 'teams', 'indoor', 'cross', 'track'));
    }

    /**
     * Update the given post.
     * @param  \App\Http\Requests\UpdateCompetitionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompetitionsRequest $request, $id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition = Competition::findOrFail($id);
        $competition->update($request->all());
        return redirect('/admin/competitions');
    }

    public function create()
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $addresses   = Address::get()->pluck('name', 'id')->prepend('Please select', '');
        $teams       = Team::get()->pluck('name', 'id')->prepend('Please select', '');
        $competition = '';
        $track = 'active';
        $cross = '';
        $indoor = '';
        return view('admin.competitions.create', compact('addresses', 'teams', 'competition', 'indoor', 'cross', 'track'));
    }

    use FileUploadTrait;
    public function store(StoreCompetitionsRequest $request)
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $timetables = $this->parseCSV($request, true);
        $request['timetable_1'] = $timetables['timetable_1'];
        $request['timetable_2'] = $timetables['timetable_2'];

        Competition::create($request->all());
        return redirect('/admin/competitions');
    }

    /**
     * Remove Game from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('competition_delete')) {
            return abort(401);
        }
        $game = Competition::findOrFail($id);
        $game->delete();
        return redirect()->route('admin.competitions.index');
    }
}
