<?php

namespace App\Http\Controllers\Admin;

use App\Additional;
use App\Competition;
use App\Address;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreCompetitionsRequest;
use App\Http\Requests\Admin\UpdateCompetitionsRequest;
use App\Organizer;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $additionals = Additional::where('external_id', '=', $competition->id)->get();
        return view('admin.competitions.show', compact('competition', 'additionals'));
    }

    public function edit($id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition      = Competition::findOrFail($id);
        $addresses        = Address::get()->pluck('name', 'id');
        $organizers       = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        $additionals      = Additional::where('external_id', '=', $id)->get();
        $season['track']  = $competition->season == 'bahn' ? 'active' : '';
        $season['indoor'] = $competition->season == 'halle' ? 'active' : '';
        $season['cross']  = $competition->season == 'cross' ? 'active' : '';
        if ($competition->register) {
            $register['internal'] = 'active';
        } else {
            $register['external'] = 'active';
        }
        if ($competition->only_list) {
            $onlyList['list'] = 'active';
        } else {
            $onlyList['not_list'] = 'active';
        }
        return view('admin.competitions.update', compact('addresses', 'competition', 'organizers', 'season', 'additionals', 'register', 'onlyList'));
    }

    /**
     * Update the given post.
     * @param UpdateCompetitionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    use FileUploadTrait;
    public function update(UpdateCompetitionsRequest $request, $id)
    {

        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition              = Competition::findOrFail($id);
        $submitData                = $request->all();
        $submitData['timetable_1'] = $this->parsingTable($submitData['timetable_1']);
        $competition->update($submitData);
        if (!empty($submitData['keyvalue'])) {
            foreach ($submitData['keyvalue'] as $key => $keyVal) {
                Additional::updateOrCreate(
                    ['id' => $key,
                     'external_id' => $competition->id],
                    ['key' => $keyVal['key'],
                     'value' => $keyVal['value'],
                     'mnemonic' => $competition->season,
                    ]
                );
            }
        }
        return redirect('/admin/competitions');
    }

    use FileUploadTrait;
    public function uploader(Request $request, $id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition                = Competition::findOrFail($id);
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
        $addresses   = Address::get()->pluck('name', 'id')->prepend('Please select', '');
        $organizers  = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        $competition = '';
        $register['external']       = '';
        $register['internal']       = '';
        $onlyList['list']       = '';
        $onlyList['not_list']       = '';
        $season['track']     = '';
        $season['indoor']     = '';
        $season['cross']     = '';
        return view('admin.competitions.create', compact('addresses', 'organizers', 'competition', 'season', 'additionals', 'register', 'onlyList'));
    }
    use FileUploadTrait;
    public function store(StoreCompetitionsRequest $request)
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        $data = $request->all();
        $data['timetable_1'] = $this->parsingTable($data['timetable_1']);
        $id   = Competition::create($data)->id;
        if (!empty($data['keyvalue'])) {
            foreach ($data['keyvalue'] as $keyval) {
                $keyval['external_id'] = $id;
                $keyval['mnemonic']    = $request->season;
                Additional::create($keyval);
            }
        }
        return redirect('/admin/competitions/' . $id);
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

    public function delete_file($id)
    {
        if (!Gate::allows('competition_delete_file')) {
            return abort(401);
        }
        $uploadedFile = Upload::findOrFail($id);
        $competition  = Competition::findOrFail($uploadedFile->competition_id);
        Storage::delete('public/' . $uploadedFile->type . '/' . $competition->season . '/' . $uploadedFile->filename);
        $uploadedFile->delete();
        return redirect()->route('admin.competitions.edit', $competition->id);
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
