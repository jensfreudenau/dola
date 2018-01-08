<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, "de_DE");
        if ($this->app->environment() == 'local') {
            $this->app->register('Appzcoder\CrudGenerator\CrudGeneratorServiceProvider');
        }
        $this->app->bind('App\Repositories\Competition\CompetitionRepositoryInterface', 'App\Repositories\Competition\CompetitionRepository');
        $this->app->bind('App\Repositories\Record\RecordRepositoryInterface', 'App\Repositories\Record\RecordRepository');
        $this->app->bind('App\Repositories\Address\AddressRepositoryInterface', 'App\Repositories\Address\AddressRepository');
        $this->app->bind('App\Repositories\Page\PageRepositoryInterface', 'App\Repositories\Page\PageRepository');
        $this->app->bind('App\Repositories\Participator\ParticipatorRepositoryInterface', 'App\Repositories\Participator\ParticipatorRepository');
    }
}
