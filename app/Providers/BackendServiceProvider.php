<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.01.18
 * Time: 14:41
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Repositories\Competition\CompetitionRepositoryInterface', 'App\Repositories\Competition\CompetitionRepository');

    }
}