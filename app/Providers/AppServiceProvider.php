<?php

namespace App\Providers;

use App\Repositories\Additional\AdditionalRepository;
use App\Repositories\Organizer\OrganizerRepository;
use App\Services\CompetitionService;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Psr\Log\LoggerInterface;

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
        $this->app->bind('App\Repositories\Additional\AdditionalRepositoryInterface', AdditionalRepository::class);
        $this->app->bind('App\Repositories\Organizer\OrganizerRepositoryInterface', OrganizerRepository::class);
        $this->app->bind('CompetitionService', CompetitionService::class);
        $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', LoggerInterface::class);
    }
}
