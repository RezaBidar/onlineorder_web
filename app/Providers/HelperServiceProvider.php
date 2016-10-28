<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    protected $helpers = [
        'App' ,
    ];


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->helpers as $helper) {
            $helper_path = app_path().'/Helpers/'.$helper.'Helper.php';

            if (\File::isFile($helper_path)) {
                require_once $helper_path;
            }
        }
    }
}
