<?php

namespace App\Http\Controllers;

use App\Additional;
use App\Competition;
use App\Http\Requests;
use DateTime;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

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
        $additionals = Additional::where('external_id', '=', $competition->id)->get();
        return view('front.competitions.details', compact('competition', 'additionals'));
    }

    public function archive()
    {
        $seasons = ['bahn', 'halle', 'cross'];
        foreach ($seasons as $season) {
            $path  = 'public/' . Config::get('constants.Results') . '/' . $season->season;
            $files = Storage::files($path);
            $archives[$season->season] = $this->listdir_by_date($files);
        }
        return view('front.competitions.archive', compact('archives'));
    }

    protected function listdir_by_date($files)
    {
        $list = [];
        foreach ($files as $key => $file) {
            if (basename($file) == 'styles.css') continue;
            if (basename($file) == 'index.html') continue;
            // add the filename, to be sure not to
            // overwrite a array key
            list($filebase, $ending) = explode(".", $file);
            if ($ending != 'html') continue;
//
            preg_match_all('/[0-9]/', $filebase, $match);
            if (count($match[0]) < 6) continue;
            $six = false;
            if (count($match[0]) == 6) {
                $six = true;
            }
            if (count($match[0]) > 8) {
                $match[0][8] = '';
            }
            $v = implode($match[0]);
            if ($six) {
                $v = '20' . $v;
            }
            $date                               = new DateTime($v);
            $list[$date->format('Y')][$key]['file'] = $file;
            $list[$date->format('Y')][$key]['date'] = $date->format('d.m.Y');
        }
        return $list;
    }
}
