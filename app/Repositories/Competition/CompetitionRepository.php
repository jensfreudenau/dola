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
use App\Traits\StringMarkerTrait;

class CompetitionRepository extends Repository implements CompetitionRepositoryInterface
{
    public    $seasons = ['bahn', 'halle', 'cross'];
    protected $model;

    public function __construct(Competition $model)
    {
        $this->model = $model;
    }

    function model()
    {
        return Competition::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */

    public function getFutured()
    {
        $competitions = $this->model->orderBy('start_date', 'asc')->whereDate('start_date', '>', date('Y-m-d'))->get();
        foreach ($competitions as $competition) {
            $competition->ageclasses = $competition->reduceClasses();
        }
        return $competitions;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getElapsed()
    {
        $competitions = $this->model->orderBy('start_date', 'desc')->whereDate('start_date', '<=', date('Y-m-d'))->get();
        foreach ($competitions as $competition) {
            $competition->ageclasses = $competition->reduceClasses();
        }
        return $competitions;
    }
}