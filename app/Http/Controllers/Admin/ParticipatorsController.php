<?php

namespace App\Http\Controllers\Admin;

use App\Announciator;
use App\Competition;
use App\Organizer;
use App\Participator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreParticipatorsRequest;
use App\Http\Requests\Admin\UpdateParticipatorsRequest;
#use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response;

class ParticipatorsController extends Controller
{
    /**
     * Display a listing of participator.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('participator_access')) {
            return abort(401);
        }
        $participators = Participator::all();
        return view('admin.participators.index', compact('participators'));
    }

    public function list($competitionId)
    {
        if (!Gate::allows('participator_access')) {
            return abort(401);
        }
        $competition = Competition::findOrFail($competitionId);
        dd($competition->Participators);
        return view('admin.participators.list', compact('competition'));
    }

    /**
     * Show the form for creating new participator.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('participator_create')) {
            return abort(401);
        }
        $teams = Organizer::get()->pluck('name', 'id')->prepend('Please select', '');
        return view('admin.participators.create', compact('teams'));
    }

    /**
     * Store a newly created participator in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreParticipatorsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParticipatorsRequest $request)
    {
        if (!Gate::allows('participator_create')) {
            return abort(401);
        }
        Participator::create($request->all());
        return redirect()->route('admin.participators.index');
    }

    /**
     * Display participator.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('participator_view')) {
            return abort(401);
        }
        $participator = Participator::findOrFail($id);
        return view('admin.participators.show', compact('participator'));
    }

    public function download($id)
    {
        $competition = Competition::findOrFail($id);
        foreach ($competition->Participators as $key => $participator) {
            $list[$key]['BIB']        = 1;
            $list[$key]['Code']       = '';
            $list[$key]['Event']      = $competition->header;
            $list[$key]['Team']       = $participator->Announciator->clubname;
            $list[$key]['telephone']  = $participator->Announciator->telephone;
            $list[$key]['street']     = $participator->Announciator->street;
            $list[$key]['city']       = $participator->Announciator->city;
            $list[$key]['Forename']   = $participator->prename;
            $list[$key]['Name']       = $participator->lastname;
            $list[$key]['Value']      = $participator->best_time;
            $list[$key]['YOB']        = $participator->birthyear;
            $list[$key]['discipline'] = $participator->discipline->dlv;
            $list[$key]['ageclass']   = $participator->ageclass->dlv;
        }
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-type' => 'text/csv'
            , 'Content-Disposition' => 'attachment; filename=participators.csv'
            , 'Expires' => '0'
            , 'Pragma' => 'public'
        ];
        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));
        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };
        return response()->stream($callback, 200, $headers);
        #return Response::download($callback, 'tweets.csv', $headers);
        #return Response::stream($callback, 200, $headers);
    }
}
