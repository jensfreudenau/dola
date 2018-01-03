<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 17:24
 */

namespace App\Repositories\Record;
use App\Models\Record;
use App\Repositories\Repository;

class RecordRepository extends Repository implements RecordRepositoryInterface
{
    protected $model;

    public function __construct(Record $model)
    {
        $this->model = $model;
    }

    /**
     * @param $string
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getKreisRecords($string){
        return Record::where('sex', '=', $string)->where('type', '=', 'kreis')->orderBy('sort')->orderBy('header')->get();
    }

    /**
     * @param $string
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getNonKreisRecords($string)
    {
        return Record::where('sex', '=', $string)->where('type', '<>', 'kreis')->orderBy('sort')->orderBy('header')->get();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Record::class;
    }
}