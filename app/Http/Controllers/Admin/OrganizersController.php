<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use App\Models\Competition;
use App\Models\Organizer;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamsRequest;
use App\Http\Requests\Admin\UpdateTeamsRequest;

class OrganizersController extends Controller
{
    /**
     * Display a listing of Organizer.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('organizer_access')) {
            return abort(401);
        }
        $organizers = Organizer::all();
        return view('admin.organizers.index', compact('organizers'));
    }

    /**
     * Show the form for creating new organizer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('organizer_create')) {
            return abort(401);
        }
        $addresses = Address::get()->pluck('name', 'id')->prepend('Please select', '');
        return view('admin.organizers.create', compact('addresses'));
    }

    /**
     * Store a newly created Team in storage.
     *
     * @param StoreTeamsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamsRequest $request)
    {
        if (!Gate::allows('organizer_create')) {
            return abort(401);
        }
        Organizer::create([
                              'name' => $request->name,
                              'leader' => $request->leader,
                              'addresses_id' => $request->address_id,
                              'homepage' => $request->homepage,
                          ]);
        return redirect()->route('admin.organizers.index');
    }

    /**
     * Show the form for editing Team.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('organizer_edit')) {
            return abort(401);
        }
        $organizer = Organizer::findOrFail($id);
        $addresses = Address::get()->pluck('name', 'id');
        return view('admin.organizers.edit', compact('organizer', 'addresses'));
    }

    /**
     * Update Team in storage.
     *
     * @param UpdateTeamsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamsRequest $request, $id)
    {
        if (!Gate::allows('organizer_edit')) {
            return abort(401);
        }
        $organizer = Organizer::findOrFail($id);
        $organizer->update($request->all());
        return redirect()->route('admin.organizers.index');
    }

    /**
     * Display Team.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('organizer_view')) {
            return abort(401);
        }
        $tracks    = Competition::where('organizer_id', $id)->where('season', 'bahn')->get();
        $indoors   = Competition::where('organizer_id', $id)->where('season', 'halle')->get();
        $crosses   = Competition::where('organizer_id', $id)->where('season', 'cross')->get();
        $organizer = Organizer::findOrFail($id);
        return view('admin.organizers.show', compact('organizer', 'tracks', 'indoors', 'crosses'));
    }

    /**
     * Remove Team from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('organizer_delete')) {
            return abort(401);
        }
        $organizer = Organizer::findOrFail($id);
        $organizer->delete();
        return redirect()->route('admin.organizers.index');
    }

    /**
     * Delete all selected organizer at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('organizer_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Organizer::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
