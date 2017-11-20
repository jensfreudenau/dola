<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Record;
use App\Best;
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
        $kreisFemales = Record::where('sex', '=', 'f')->where('type', '=', 'kreis')->orderBy('sort')->orderBy('header')->get();
        $kreisMales =   Record::where('sex', '=', 'm')->where('type', '=', 'kreis')->orderBy('sort')->orderBy('header')->get();
        $females = Record::where('sex', '=', 'f')->where('type', '<>', 'kreis')->orderBy('sort')->orderBy('header')->get();
        $males =   Record::where('sex', '=', 'm')->where('type', '<>', 'kreis')->orderBy('sort')->orderBy('header')->get();
        return view('front.records.index', compact('kreisFemales', 'kreisMales', 'females', 'males'));
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

        if($request->sex == 'female') {
            $bests = Best::where('sex', '=', 'f')->orderBy('year', 'desc')->get();
            $header = 'Frauen';
            $file = 'Frauen';
        }       
        if($request->sex == 'male') {
            $bests = Best::where('sex', '=', 'm')->orderBy('year', 'desc')->get();
            $header = 'M&auml;nner';
            $file = 'Maenner';
        } 
        return view('front.records.best', compact('bests', 'header', 'file'));
    }
}
