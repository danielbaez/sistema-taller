<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $location = request()->segment(1);
        //dd($location);
        \Gate::define('aaabbbccc', function ($user) {
            dd($user);
            return false;
        });
    }
}
