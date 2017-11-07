<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Record;
use Illuminate\Http\Request;
use Session;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $females = Record::orderBy('header')->where('sex', '=', 'f')->get();
        $males = Record::orderBy('header')->where('sex', '=', 'm')->get();
        return view('front.records.index', compact('females', 'males'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function record($id)
    {
        $record = Record::findOrFail($id);
        return view('front.records.detail', compact('record'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function best(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $statistic = Record::paginate($perPage);
        } else {
            $statistic = Record::paginate($perPage);
        }

        return view('front.records.best', compact('statistic'));
    }
}
