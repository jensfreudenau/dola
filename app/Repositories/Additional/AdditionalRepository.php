<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 15:58
 */

namespace App\Repositories\Additional;

use App\Models\Additional;
use App\Repositories\Repository;

class AdditionalRepository extends Repository implements AdditionalRepositoryInterface
{
    protected $model;

    public function __construct(Additional $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Additional::all();
    }

    function model()
    {
        return Additional::class;
    }


}