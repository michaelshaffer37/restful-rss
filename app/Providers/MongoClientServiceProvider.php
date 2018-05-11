<?php

namespace App\Providers;

use App\Contracts\Data\MongoClientInterface;
use App\Data\MongoClient;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

/**
 * Class MongoClientServiceProvider
 *
 * @package App\Providers
 */
class MongoClientServiceProvider extends ServiceProvider
{
    /**
     * Register a binding for the MongoDb Client in the IOC container for the app.
     */
    public function register()
    {
        $this->app->bind(MongoClientInterface::class, function (Application $app) {
            return new MongoClient("mongodb://{$app['config']->get('database.connections.mongodb.host')}/");
        });

        $this->app->alias(MongoClientInterface::class, 'mongodb');
    }
}
