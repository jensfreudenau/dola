<?php
namespace App\Repositories\HashLogin;

use App\Models\HashLogin;
use App\Repositories\Repository;

class HashLoginRepository extends Repository implements HashLoginRepositoryInterface
{
    protected $model;

    public function __construct(HashLogin $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return HashLogin::all();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return HashLogin::class;
    }
}