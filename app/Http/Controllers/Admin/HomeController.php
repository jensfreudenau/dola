<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
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
        $announces = array();

        foreach ($competitions as $key => $competition) {
            try {
            $announces[] = DB::table('participators')
                ->select('participators.created_at', DB::raw('count(*) as anzahl'))
                ->orderBy('participators.created_at')
                ->groupBy('participators.created_at')
                ->join('announciators', 'participators.announciator_id', '=', 'announciators.id')
                ->where('announciators.competition_id', '=', $competition->id)
                ->get();
            } catch(Error $competition) {
                continue;
            } catch(Throwable $competition) {
                continue;// This should work as well
            }
        }

        return view('admin.home.index', compact('announces', 'competitions'));
    }

}
