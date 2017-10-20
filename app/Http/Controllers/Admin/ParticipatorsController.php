<?php

namespace App\Http\Controllers\Admin;

use App\Participator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreParticipatorsRequest;
use App\Http\Requests\Admin\UpdateParticipatorsRequest;

class ParticipatorsController extends Controller
{
    /**
     * Display a listing of participator.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('participator_access')) {
            return abort(401);
        }

        $participators = Participator::all();

        return view('admin.participators.index', compact('participators'));
    }

    /**
     * Show the form for creating new participator.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('participator_create')) {
            return abort(401);
        }
        $teams = \App\Team::get()->pluck('name', 'id')->prepend('Please select', '');

        return view('admin.participators.create', compact('teams'));
    }

    /**
     * Store a newly created participator in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreParticipatorsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParticipatorsRequest $request)
    {
        if (! Gate::allows('participator_create')) {
            return abort(401);
        }
        $participator = Participator::create($request->all());



        return redirect()->route('admin.participators.index');
    }


    /**
     * Show the form for editing participator.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('participator_edit')) {
            return abort(401);
        }
        $teams = \App\Team::get()->pluck('name', 'id')->prepend('Please select', '');

        $participator = Participator::findOrFail($id);

        return view('admin.participators.edit', compact('participator', 'teams'));
    }

    /**
     * Update participator in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateParticipatorsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParticipatorsRequest $request, $id)
    {
        if (! Gate::allows('participator_edit')) {
            return abort(401);
        }
        $participator = Participator::findOrFail($id);
        $participator->update($request->all());



        return redirect()->route('admin.participators.index');
    }


    /**
     * Display participator.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('participator_view')) {
            return abort(401);
        }
        $participator = Participator::findOrFail($id);

        return view('admin.participators.show', compact('participator'));
    }


    /**
     * Remove participator from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('participator_delete')) {
            return abort(401);
        }
        $participator = Participator::findOrFail($id);
        $participator->delete();

        return redirect()->route('admin.participators.index');
    }

    /**
     * Delete all selected participator at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('participator_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Participator::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
