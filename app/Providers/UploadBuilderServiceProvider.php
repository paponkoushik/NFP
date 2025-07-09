<?php

namespace App\Providers;

use App\Actions\UploadBuilder;
use Illuminate\Support\ServiceProvider;

class UploadBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UploadBuilder::class, function () {
            return new UploadBuilder;
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
