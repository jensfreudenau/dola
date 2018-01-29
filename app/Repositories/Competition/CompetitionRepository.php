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

    function model()
    {
        return Competition::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getFutured()
    {
        return $this->model->orderBy('start_date', 'asc')->whereDate('start_date', '>', date('Y-m-d'))->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getElapsed()
    {
        return $this->model->orderBy('start_date', 'asc')->whereDate('start_date', '<', date('Y-m-d'))->get();
    }

}