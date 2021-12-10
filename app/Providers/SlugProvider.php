<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Slug;

class SlugProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Slug', function () {
            return new Slug();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
