<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 15:59
 */

namespace App\Repositories\Address;
interface AddressRepositoryInterface
{
    public function getAll();
    public function findById($id);
}