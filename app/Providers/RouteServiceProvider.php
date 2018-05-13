<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RouteServiceProvider
 *
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        /**
         * Force use of the app url for generating urls, this way
         * the api & worker can build the same values.
         */
        $this->app->make('url')->forceRootUrl(config('app.url'));
    }
}
