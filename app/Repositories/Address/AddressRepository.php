<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 15:58
 */

namespace App\Repositories\Address;

use App\Models\Address;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Log;

class AddressRepository extends Repository implements AddressRepositoryInterface
{
    protected $model;

    public function __construct(Address $model)
    {
        Log::info('AddressRepository');
        Log::info($model);
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Address::all();
    }

    function model()
    {
        return Address::class;
    }


}