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

        // Site Wide Announcements (Public)
        view()->composer('landing', function ($view) {
            $view->with('publicAnnouncements', app(\App\Services\AnnouncementService::class)->getPublicAnnouncements());
        });

        // Dashboard Announcements (Internal)
        view()->composer(['desa.*', 'kecamatan.*', 'layouts.*'], function ($view) {
            if (auth()->check()) {
                $service = app(\App\Services\AnnouncementService::class);
                if (auth()->user()->desa_id) {
                    $view->with('internalAnnouncements', $service->getDesaAnnouncements(auth()->user()->desa_id));
                } else {
                    $view->with('internalAnnouncements', $service->getInternalAnnouncements());
                }
            }
        });
    }
}
