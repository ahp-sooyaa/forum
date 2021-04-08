<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Channel;

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
        // View::share('channels', Channel::all()); this will cause errors in all test cases.

        View::composer('*', function ($view) {
            // $channels = \Cache::rememberForever('channels', function () {
            $channels = Channel::all();
            // });
            $view->with('channels', $channels);
        });
    }
}
