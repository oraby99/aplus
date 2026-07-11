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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $academyInfo = \App\Models\AcademyInfo::first() ?? new \App\Models\AcademyInfo();
            \Illuminate\Support\Facades\View::share('academyInfo', $academyInfo);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('academyInfo', new \App\Models\AcademyInfo());
        }
    }
}
