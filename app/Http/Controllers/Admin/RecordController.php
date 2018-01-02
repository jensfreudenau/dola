<?php

namespace App\Http\Controllers\Admin;

use App\Best;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Session;
use Illuminate\Support\Facades\Log;
class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index()
    {
//        if (!Gate::allows('records_access')) {
//            return abort(401);
//        }
        $records = Record::orderBy('sex')->orderBy('sort')->get();
        return view('admin.records.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.records.create');
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

        $requestData = $request->all();
        Record::create($requestData);
        Session::flash('flash_message', ' added!');
        return redirect('admin/records');
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
        $record = Record::findOrFail($id);
        return view('admin.records.show', compact('record'));
    }

public function sort(Request $request)
{
    Log::info($request);
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
        $record = Record::findOrFail($id);
        $female = ['checked' => 0, 'active' => ''];
        $male   = ['checked' => 0, 'active' => ''];
        if ($record->sex == 'f') {
            $female['checked'] = 1;
            $female['active']  = 'active';
        }
        if ($record->sex == 'm') {
            $male['checked'] = 1;
            $male['active']  = 'active';
        }
        return view('admin.records.edit', compact('record', 'female', 'male'));
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
        $record = Record::findOrFail($id);
        $record->update($requestData);
        Session::flash('flash_message', ' updated!');
        return redirect('admin/records');
    }

    public function beststore(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $filename = $request->file($key)->getClientOriginalName();
                Storage::putFileAs('public/bestenliste', $request->file('file'), $filename);
                $finalRequest = new Request(array_merge($request->all(), ['filename' => $filename]));
                Best::create($finalRequest->all());
            }
        }
        return redirect('admin/records');
    }

    public function bestsindex()
    {
        $bests = Best::orderBy('year')->orderBy('filename')->get();
        return view('admin.records.bestsindex', compact('bests'));
    }

    public function uploads()
    {


//        foreach ($bests as $best) {
//            $bestMo =  Best::findOrFail($best->id);
//            $bestMo->filename = 'KBL_'.$best->year.'_Maenner.pdf';
//            $bestMo->update();
//       }
        return view('admin.records.uploads');
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
        Record::destroy($id);
        Session::flash('flash_message', ' deleted!');
        return redirect('admin.records');
    }
}
