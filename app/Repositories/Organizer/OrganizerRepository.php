<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 15:58
 */

namespace App\Repositories\Organizer;

use App\Models\Organizer;
use App\Repositories\Repository;

class OrganizerRepository extends Repository implements OrganizerRepositoryInterface
{
    protected $model;

    public function __construct(Organizer $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Organizer::all();
    }

    function model()
    {
        return Organizer::class;
    }


}