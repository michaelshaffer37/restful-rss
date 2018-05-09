<?php

namespace App\Providers;

use App\Contracts\Data\MongoClientInterface;
use App\Data\Model;
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
     * Configure the mongo Database and configure it on the Data Model
     */
    public function boot()
    {
        $mongoDb = $this->app->make('mongo')->selectDatabase(
                $this->app->make('config')->get('mongo.database')
            );

        Model::setDatabase($mongoDb);
    }

    /**
     * Register a binding for the MongoDb Client in the IOC container for the app.
     */
    public function register()
    {
        $this->app->bind(MongoClientInterface::class, function (Application $app) {
            return new MongoClient("mongodb://{$app['config']->get('mongo.host')}/");
        });

        $this->app->alias(MongoClientInterface::class, 'mongo');
    }
}
