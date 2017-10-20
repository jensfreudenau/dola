<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamsRequest;
use App\Http\Requests\Admin\UpdateTeamsRequest;

class TeamsController extends Controller
{
    /**
     * Display a listing of Team.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('team_access')) {
            return abort(401);
        }

        $teams = Team::all();

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating new Team.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('team_create')) {
            return abort(401);
        }
        $addresses = Address::get()->pluck('name', 'id')->prepend('Please select', '');
        return view('admin.teams.create', compact('addresses'));
    }

    /**
     * Store a newly created Team in storage.
     *
     * @param StoreTeamsRequest|\App\Http\Requests\StoreTeamsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamsRequest $request)
    {
        if (! Gate::allows('team_create')) {
            return abort(401);
        }

        $team = Team::create([
            'name'    => $request->name,
            'leader'    => $request->leader,
            'addresses_id'    => $request->address_id,
            'homepage'    => $request->homepage,
        ]);



        return redirect()->route('admin.teams.index');
    }


    /**
     * Show the form for editing Team.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('team_edit')) {
            return abort(401);
        }
        $team = Team::findOrFail($id);
        $addresses = Address::get()->pluck('name', 'id');
        return view('admin.teams.edit', compact('team', 'addresses'));
    }

    /**
     * Update Team in storage.
     *
     * @param UpdateTeamsRequest|\App\Http\Requests\UpdateTeamsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamsRequest $request, $id)
    {
        if (! Gate::allows('team_edit')) {
            return abort(401);
        }
        $team = Team::findOrFail($id);
        $team->update($request->all());



        return redirect()->route('admin.teams.index');
    }


    /**
     * Display Team.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('team_view')) {
            return abort(401);
        }
        $tracks = \App\Competition::where('team_id', $id)->where('season', 'bahn')->get();
        $indoors = \App\Competition::where('team_id', $id)->where('season', 'halle')->get();
        $crosses = \App\Competition::where('team_id', $id)->where('season', 'cross')->get();

        $team = Team::findOrFail($id);

        return view('admin.teams.show', compact('team', 'tracks', 'indoors', 'crosses'));
    }


    /**
     * Remove Team from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('team_delete')) {
            return abort(401);
        }
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect()->route('admin.teams.index');
    }

    /**
     * Delete all selected Team at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('team_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Team::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
