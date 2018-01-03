<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 02.01.18
 * Time: 15:39
 */

namespace App\Repositories\Competition;
interface CompetitionRepositoryInterface
{
    public function getAll();

    public function findById($id);

    public function findBySeason($season);
}