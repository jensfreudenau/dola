<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 17:25
 */

namespace App\Repositories\Record;
interface RecordRepositoryInterface
{
    public function findById($id);

    public function getKreisRecords($string);

    public function getNonKreisRecords($string);
}