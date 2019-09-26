<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
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
        if($this->app->isLocal()){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //This function use to pass instance of Model as Variable to specific view
        View::composer('*', function($view)
        {
            $channels= Cache::rememberForever('channels',function (){
               return Channel::all();
            });
            $view->with('channels',$channels);
        });
         //This function use to pass instance of Model as Variable to all view
//        View::share('channels',Channel::all());


    }
}
