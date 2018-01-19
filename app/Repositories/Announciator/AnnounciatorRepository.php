<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 15:58
 */

namespace App\Repositories\Announciator;

use App\Models\Announciator;
use App\Repositories\Repository;

class AnnounciatorRepository extends Repository implements AnnounciatorRepositoryInterface
{
    protected $model;

    public function __construct(Announciator $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Announciator::all();
    }

    function model()
    {
        return Announciator::class;
    }


}