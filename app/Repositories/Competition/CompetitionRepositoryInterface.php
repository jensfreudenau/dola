<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 02.01.18
 * Time: 15:39
 */

namespace App\Repositories\Competition;
use App\Models\Competition;

interface CompetitionRepositoryInterface
{
    public function findBySeason($season);

    public function getActiveSeason(Competition $competition);

    public function getActiveRegister(Competition $competition);

    public function getActiveListed(Competition $competition);
}