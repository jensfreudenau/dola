<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 15:59
 */

namespace App\Repositories\Announciator;
interface AnnounciatorRepositoryInterface
{
    public function getAll();
    public function findById($id);
}