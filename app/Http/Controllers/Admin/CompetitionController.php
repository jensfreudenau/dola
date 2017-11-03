<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use App\Address;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreCompetitionsRequest;
use App\Http\Requests\Admin\UpdateCompetitionsRequest;
use App\Team;
use App\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CompetitionController extends Controller
{
    public function index()
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competitions = Competition::orderBy('start_date', 'desc')->get();
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
        $track       = '';
        $cross       = '';
        $indoor      = '';
        if ($competition->season == 'bahn') {
            $track = 'active';
        }
        if ($competition->season == 'cross') {
            $cross = 'active';
        }
        if ($competition->season == 'halle') {
            $indoor = 'active';
        }
        if ($competition->season == 'halle') {
            $indoor = 'active';
        }
        return view('admin.competitions.update', compact('addresses', 'competition', 'teams', 'indoor', 'cross', 'track'));
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
        $competition = Competition::findOrFail($id);
        $competition->update($request->all());
        return redirect('/admin/competitions');
    }

    use FileUploadTrait;
    public function participator(Request $request, $id)
    {
//        if (!Gate::allows('competition_participator')) {
//            return abort(401);
//        }
        $uploads                    = $this->saveFiles($request);
        $requests                   = $request->all();
        $requests['competition_id'] = $id;
        $requests['type']           = Config::get('constants.Participators');
        $requests['filename']       = $uploads->file;
        Upload::create($requests);
        return 'done';
    }

    public function resultsets(Request $request, $id)
    {
//        if (!Gate::allows('competition_resultlists')) {
//            return abort(401);
//        }
        $request['type']            = Config::get('constants.Results');
        $uploads                    = $this->saveFiles($request);
        $requests                   = $request->all();
        $requests['competition_id'] = $id;
        $requests['filename']       = $uploads->resultsets;
        Upload::create($requests);
        return 'done';
    }

    public function create()
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $addresses   = Address::get()->pluck('name', 'id')->prepend('Please select', '');
        $teams       = Team::get()->pluck('name', 'id')->prepend('Please select', '');
        $competition = '';
        $track       = '';
        $cross       = '';
        $indoor      = '';
        return view('admin.competitions.create', compact('addresses', 'teams', 'competition', 'indoor', 'cross', 'track'));
    }

    public function store(StoreCompetitionsRequest $request)
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $id = Competition::create($request->all())->id;
        return redirect('/admin/competitions/'.$id);
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
        $competition = Competition::findOrFail($id);
        $competition->delete();
        return redirect()->route('admin.competitions.index');
    }

    public function delete_file($id, Request $request)
    {
        $requestAll = $request->all();
        $filename = Upload::findOrFail($id);
        File::delete('upload/'.$filename->type.'/'.$filename->filename);
        $filename->delete();
        return redirect()->route('admin.competitions.edit', $requestAll['competition_id']);
    }

    /**
     * Delete all selected Game at once.
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
