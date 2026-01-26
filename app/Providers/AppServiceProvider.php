<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\SubmissionRepositoryInterface::class,
            \App\Repositories\SubmissionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Menu::observe(\App\Observers\MenuObserver::class);
        \App\Models\Aspek::observe(\App\Observers\AspekObserver::class);
        \App\Models\Indikator::observe(\App\Observers\IndikatorObserver::class);
    }
}
