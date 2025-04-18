<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    $currentHour = Carbon::now()->hour;
    if ($currentHour < 12) {
        $greeting = "Good Morning";
    } elseif ($currentHour < 18) {
        $greeting = "Good Afternoon";
    } else {
        $greeting = "Good Evening";
    }

    View::share('greeting', $greeting);
}
}
