<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use App\ParticipatorTeam;
use Carbon\Carbon;
use Ifnot\Statistics\Interval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $competitions = Competition::orderBy('start_date', 'asc')
            ->whereDate('start_date', '>', date('Y-m-d'))->take(4)->get();
        foreach ($competitions as $competition) {
            $announces[] = DB::table('participators')
                ->select('participators.created_at', DB::raw('count(*) as anzahl'))
                ->orderBy('participators.created_at')
                ->groupBy('participators.created_at')
                ->join('participator_teams', 'participators.participator_team_id', '=', 'participator_teams.id')
                ->where('participator_teams.competition_id', '=', $competition->id)
                ->get();
        }

        $reportLabel = 'Anmeldungen';
        return view('admin.home.index', compact('announces', 'reportLabel', 'competitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('home.create');
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
        Session::flash('flash_message', ' added!');
        return redirect('home');
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


        return view('home.show', compact('home'));
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


        return view('home.edit', compact('home'));
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
        $home->update($requestData);
        Session::flash('flash_message', ' updated!');
        return redirect('home');
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


        Session::flash('flash_message', ' deleted!');
        return redirect('home');
    }
}
