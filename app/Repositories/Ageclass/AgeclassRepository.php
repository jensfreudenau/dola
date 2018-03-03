<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 15:58
 */

namespace App\Repositories\Ageclass;

use App\Models\Ageclass;
use App\Repositories\Repository;

class AgeclassRepository extends Repository implements AgeclassRepositoryInterface
{
    protected $model;

    public function __construct(Ageclass $model)
    {
        $this->model = $model;
    }

    public function model()
    {
        return Ageclass::class;
    }

    public function whereNotNull($field)
    {
        return Ageclass::whereNotNull($field)->orderBy($field)->get();
    }

}