<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NordigenService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NordigenService::class, function($app) {
            return new NordigenService(getenv('SECRET_ID'), getenv('SECRET_KEY'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
