<?php

namespace App\Providers;

use App\Repositories\Additional\AdditionalRepository;
use App\Repositories\Organizer\OrganizerRepository;
use App\Repositories\PageRepository;
use App\Repositories\PageRepositoryEloquent;
use App\Services\AnnounciatorService;
use App\Services\CompetitionService;
use App\Services\ParticipatorService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        $this->app->bind('App\Repositories\Competition\CompetitionRepositoryInterface', 'App\Repositories\Competition\CompetitionRepository');
        $this->app->bind('App\Repositories\Record\RecordRepositoryInterface', 'App\Repositories\Record\RecordRepository');
        $this->app->bind('App\Repositories\Address\AddressRepositoryInterface', 'App\Repositories\Address\AddressRepository');
        $this->app->bind('App\Repositories\Page\PageRepositoryInterface', 'App\Repositories\Page\PageRepository');
        $this->app->bind('App\Repositories\Participator\ParticipatorRepositoryInterface', 'App\Repositories\Participator\ParticipatorRepository');
        $this->app->bind('App\Repositories\Additional\AdditionalRepositoryInterface', 'App\Repositories\Additional\AdditionalRepository');
        $this->app->bind('App\Repositories\Organizer\OrganizerRepositoryInterface', 'App\Repositories\Organizer\OrganizerRepository');
        $this->app->bind('App\Repositories\Announciator\AnnounciatorRepositoryInterface', 'App\Repositories\Announciator\AnnounciatorRepository');
        $this->app->bind('CompetitionService', CompetitionService::class);
        $this->app->bind('AnnounciatorService', AnnounciatorService::class);
        $this->app->bind('ParticipatorService', ParticipatorService::class);
        $this->app->alias('bugsnag.logger', Log::class);
        $this->app->alias('bugsnag.logger', LoggerInterface::class);

    }
}
