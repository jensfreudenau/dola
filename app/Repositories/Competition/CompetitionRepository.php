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

class CompetitionRepository extends Repository implements CompetitionRepositoryInterface
{
    public    $seasons = ['bahn', 'halle', 'cross'];
    protected $model;

    public function __construct(Competition $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Competition::all();
    }

    public function findBySeason($season)
    {
        return Competition::orderBy('start_date', 'asc')->where('season', '=', strtolower($season))->get();
    }

    function model()
    {
        return Competition::class;
    }
}