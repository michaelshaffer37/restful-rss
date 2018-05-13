<?php

namespace App;

use Laravel\Lumen\Routing\Router;

/**
 * Class Routing
 *
 * @package App\Http
 */
class Routing
{
    /**
     * The place where all application routes should be defined.
     *
     * @param Router $router
     */
    public static function buildRoutes(Router $router)
    {
        $router->get('/', ['uses' => \App\Http\Actions\Index::class]);

        $router->group(['prefix' => 'api'], function (Router $router) {
            $router->get('feeds', ['as' => 'feed.collection', 'uses' => \App\Http\Actions\GetFeedCollection::class]);
            $router->post('feeds', ['uses' => \App\Http\Actions\LoadFeed::class]);
            $router->get('feeds/{id}', ['as' => 'feed', 'uses' => \App\Http\Actions\GetFeed::class]);

            $router->get(
                'entries',
                ['as' => 'entry.collection', 'uses' => \App\Http\Actions\GetEntryCollection::class]
            );
            $router->get('entries/{id}', ['as' => 'entry', 'uses' => \App\Http\Actions\GetEntry::class]);
        });
    }
}
