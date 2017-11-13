<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Address;
use App\Http\Requests;
use App\Participator;
use App\Announciator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompetitionsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function track()
    {
        $season       = 'Bahn';
        $competitions = Competition::orderBy('start_date', 'asc')->where('season', '=', 'bahn')->get();
        return view('front.competitions.track', compact('competitions', 'season'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indoor()
    {
        $season       = 'Halle';
        $competitions = Competition::orderBy('start_date', 'asc')->where('season', '=', 'halle')->get();
        return view('front.competitions.track', compact('competitions', 'season'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cross()
    {
        $season       = 'Strasse';
        $competitions = Competition::orderBy('start_date', 'asc')->where('season', '=', 'cross')->get();
        return view('front.competitions.track', compact('competitions', 'season'));
    }

    public function details($id)
    {
        $competition = Competition::findOrFail($id);
        return view('front.competitions.details', compact('competition'));
    }

}
