<?php

namespace App\Http\Controllers;

use App\Additional;
use App\Competition;
use App\Http\Requests;
use DateTime;
use Illuminate\Support\Facades\Config;

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
        $seasons = Competition::select('season')->distinct()->get();
        foreach ($seasons as $season) {
            $path = Config::get('constants.UploadDir')  . '/' . Config::get('constants.Results') . '/' . $season->season;
            $list = $this->listdir_by_date($path);
            foreach ($list as $key => $year) {

                echo '<h4>'.$key.'</h4>';
                foreach ($year as $file) {

                    if ($file['file'] != "." || $file['file'] != ".." || $file['file'] != "index.html" || $file['file'] != "*.xls" || $file['file'] != "styles.css" || $file['file'][0] != "t") {
                        echo '<span style="padding-left:20px;"><a href="bahn/ergebnisse/'.$file['file'].'" target="_blank">'.$file['date'].'</a></span><br />';
                    }

                }
            }
        }
    }

    protected function listdir_by_date($path){
        $dir = opendir($path);
        $list = array();
        $i = 0;
        while($file = readdir($dir)){

            if ($file != '.' and $file != '..'){
                if($file[0] == 't') continue;
                if($file == 'styles.css') continue;
                if($file == 'index.html') continue;
                // add the filename, to be sure not to
                // overwrite a array key

                list($filebase, $ending) = explode(".",$file);
                if($ending != 'html') continue;

                preg_match_all( '/[0-9]/', $filebase, $match);
                if (count($match[0]) < 6) continue;
                $six = false;
                if (count($match[0]) == 6) { $six = true;}
                if (count($match[0]) > 8) { $match[0][8] = ''; }
                $v = implode($match[0]);
                if ($six) {
                    $v = '20'.$v;
                }
                $date = new DateTime($v);

                $list[$date->format('Y')][$i]['file'] = $file;
                $list[$date->format('Y')][$i]['date'] = $date->format('d.m.Y');
                $i++;
            }
        }
        closedir($dir);
        krsort($list);
        return $list;
    }
}
