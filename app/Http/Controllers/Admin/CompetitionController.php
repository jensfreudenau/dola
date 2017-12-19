<?php

namespace App\Http\Controllers\Admin;

use App\Additional;
use App\Ageclass;
use App\Competition;
use App\Address;
use App\Discipline;
use App\Http\Controllers\Traits\ProofLADVTrait;
use App\Organizer;
use App\Upload;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Controllers\Traits\ParseDataTrait;
use App\Http\Requests\Admin\StoreCompetitionsRequest;
use App\Http\Requests\Admin\UpdateCompetitionsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    use ParseDataTrait;

    public function show($id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition = Competition::findOrFail($id);
        $additionals = Additional::where('external_id', '=', $competition->id)->get();
        $ageclasses  = $competition->Ageclasses;
        $disciplines = $competition->Disciplines;
        $competition->timetable_1 = $this->markFounded($competition->timetable_1, $ageclasses);
        $competition->timetable_1 = $this->markFounded($competition->timetable_1, $disciplines);
        return view('admin.competitions.show', compact('competition', 'additionals', 'disciplines'));
    }

    public function edit($id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition = Competition::findOrFail($id);
        $addresses   = Address::get()->pluck('name', 'id');
        $ageclasses  = Ageclass::get()->pluck('shortname', 'id')->toArray();
//        $ageclasses       = $competition->getAgeclassListAttribute();
        $organizers  = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        $additionals = Additional::where('external_id', '=', $id)->get();
        $disciplines = Discipline::pluck('shortname', 'id')->toArray();
        $season['track']  = $competition->season == 'bahn' ? 'active' : '';
        $season['indoor'] = $competition->season == 'halle' ? 'active' : '';
        $season['cross']  = $competition->season == 'cross' ? 'active' : '';

        #TODO
        #getRegister
        if ($competition->register) {
            $register['external'] = 'active';
            $register['internal'] = '';
        } else {
            $register['internal'] = 'active';
            $register['external'] = '';
        }
        #TODO
        #getListed();
        if ($competition->only_list) {
            $onlyList['list']     = 'active';
            $onlyList['not_list'] = '';
        } else {
            $onlyList['not_list'] = 'active';
            $onlyList['list']     = '';
        }
        return view('admin.competitions.edit', compact('addresses', 'competition', 'organizers', 'season', 'additionals', 'register', 'onlyList', 'ageclassList', 'ageclasses', 'disciplines'));
    }

    /**
     * Update the given post.
     * @param UpdateCompetitionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    use FileUploadTrait;
    use ParseDataTrait;
    use ProofLADVTrait;

    public function update(UpdateCompetitionsRequest $request, $id)
    {
        if (!Gate::allows('competition_edit')) {
            return abort(401);
        }
        $competition          = Competition::findOrFail($id);
        $submitData           = $request->all();
        $this->competionsList = [];
        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->parsingTable($submitData['timetable_1']);
        }
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
        $this->competionsErrorList = array();
        $this->disciplineListError = array();
        $this->ageclassErrorList   = array();
        #$this->disciplineList = array();
        #$this->ageclassList = array();
        $this->classCollection = array();
        #TODO move to Model
        foreach ($this->disciplineList as $discipline) {
            $this->proofDiscipline($discipline);
        }
        foreach ($this->disciplineListError as $key => $disciplineError) {
            #[$discipline,] = explode(' ', $disciplineError); //php7
            list($discipline, $secondArg) = explode(' ', $disciplineError);
            if (true == $this->proofDiscipline($discipline)) {
                unset($this->disciplineError[$key]);
            }
        }
        # $this->classCollection = $classes = $submitData['ageclasses'];
//        foreach ($classes as $class) {
//            if ($class == "") continue;
//            $this->proofAgeclasses($class);
//        }
        foreach ($this->ageclassList as $parsedClass) {
            $this->proofAgeclasses($parsedClass);
        }
        if ($this->ageclassErrorList) {
            return back()->withInput()->withErrors($this->ageclassErrorList);
        }
        $ids = Ageclass::whereIn('shortname', $this->ageclassCollection)->select('id')->get()->toArray();
        $competition->ageclasses()->sync($ids);
        $ids = Discipline::whereIn('shortname', $this->disciplineCollection)->select('id')->get();
        $competition->disciplines()->sync($ids);
        #return redirect('/admin/competitions');
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
        $addresses            = Address::get()->pluck('name', 'id')->prepend('Please select', '');
        $organizers           = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        $competition          = '';
        $register['external'] = '';
        $register['internal'] = '';
        $onlyList['list']     = '';
        $onlyList['not_list'] = '';
        $season['track']      = '';
        $season['indoor']     = '';
        $season['cross']      = '';
        return view('admin.competitions.create', compact('addresses', 'organizers', 'competition', 'season', 'additionals', 'register', 'onlyList'));
    }

    use ParseDataTrait;
    use FileUploadTrait;

    public function store(StoreCompetitionsRequest $request)
    {
        if (!Gate::allows('competition_create')) {
            return abort(401);
        }
        #TODO move to Model
        $submitData = $request->all();
        if (!empty($submitData['timetable_1'])) {
            $submitData['timetable_1'] = $this->parsingTable($submitData['timetable_1']);
        }
        foreach ($this->ageclassList as $class) {
            $this->proofAgeclasses($class);
        }
        foreach ($this->disciplineList as $discipline) {
            $this->proofDiscipline($discipline);
        }
        foreach ($this->disciplineCollectionError as $disciplineErr) {
            #[$discipline,] = explode(' ', $disciplineErr); //php7
            list($discipline, $secondArg) = explode(' ', $disciplineErr);
            $this->proofDiscipline($discipline);
        }
        $submitData['timetable_1'] = $this->markFounded($submitData['timetable_1']);
        $id = Competition::create($submitData)->id;
        foreach ($this->ageclassCollection as $key => $class) {
            $ageClass = Ageclass::where('ladv', '=', $key)->first();
            $ageClass->competitions()->attach($id);
        }
        foreach ($this->disciplineCollection as $key => $class) {
            $discipline = Discipline::where('ladv', '=', $key)->first();
            $discipline->competitions()->attach($id);
        }
        if (!empty($submitData['keyvalue'])) {
            foreach ($submitData['keyvalue'] as $keyval) {
                $keyval['external_id'] = $id;
                $keyval['mnemonic']    = $request->season;
                Additional::create($keyval);
            }
        }
        return redirect('/admin/competitions/' . $id);
    }

    /**
     * Remove Compe from storage.
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
     * Delete all selected Comps at once.
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
