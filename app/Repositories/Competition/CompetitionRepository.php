<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 02.01.18
 * Time: 15:32
 */

namespace App\Repositories\Competition;

use App\Models\Competition;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Log;

class CompetitionRepository extends Repository implements CompetitionRepositoryInterface
{
    public    $seasons = ['bahn', 'halle', 'cross'];
    protected $model;

    public function __construct(Competition $model)
    {
        $this->model = $model;
    }


    public function findBySeason($season)
    {
        return Competition::orderBy('start_date', 'asc')->where('season', '=', strtolower($season))->get();
    }

    function model()
    {
        return Competition::class;
    }

    public function getActiveSeason(Competition $competition)
    {
        $season['track']  = $competition->season == 'bahn' ? 'active' : '';
        $season['indoor'] = $competition->season == 'halle' ? 'active' : '';
        $season['cross']  = $competition->season == 'cross' ? 'active' : '';
        return $season;
    }

    public function getActiveRegister(Competition $competition)
    {

        if ($competition->register) {
            $register['external'] = 'active';
            $register['internal'] = '';
        } else {
            $register['internal'] = 'active';
            $register['external'] = '';
        }
        return $register;
    }

    public function getActiveListed(Competition $competition)
    {
        Log::info('getActiveRegister competition');
        Log::info((array)$this);
        if ($competition->only_list) {
            $onlyList['list']     = 'active';
            $onlyList['not_list'] = '';
        } else {
            $onlyList['not_list'] = 'active';
            $onlyList['list']     = '';
        }
        return $onlyList;
    }

}