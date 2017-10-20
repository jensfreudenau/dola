<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Competition::count();
        $competitions = Competition::orderBy('start_date', 'asc')->skip($count-5)->take(5)->get();
        $results = Competition::where('results_1', '!=', '')->orderBy('start_date', 'desc')->take(5)->get();

        return view('home', compact('competitions', 'results'));
    }
}
