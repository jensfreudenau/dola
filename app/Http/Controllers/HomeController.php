<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competitions = Competition::orderBy('start_date', 'asc')
            ->whereDate('start_date', '>', date('Y-m-d'))->take(5)->get();
        $lastcompetitions = Competition::orderBy('start_date', 'asc')
            ->whereDate('start_date', '<', date('Y-m-d'))->take(5)->get();
        return view('home', compact('competitions','lastcompetitions'));
    }
}
