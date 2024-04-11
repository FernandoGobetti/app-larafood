<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Plan;
use App\Observers\PlanObserver;

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
        Plan::observe(PlanObserver::class);
    }
}
