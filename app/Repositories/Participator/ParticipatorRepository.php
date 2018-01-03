<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 16:47
 */

namespace App\Repositories\Participator;

use App\Models\Participator;
use App\Repositories\Repository;

class ParticipatorRepository extends Repository implements ParticipatorRepositoryInterface
{
    protected $model;

    public function __construct(Participator $model)
    {
        $this->model = $model;
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Participator::class;
    }
}