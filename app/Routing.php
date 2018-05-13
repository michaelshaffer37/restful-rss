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
            $router->post('sources', \App\Http\Actions\AddSource::class);
            $router->get('sources', ['as' => 'sources', 'uses' => \App\Http\Actions\GetSourceCollection::class]);
            $router->get('sources/{id}', ['as' => 'source', 'uses' => \App\Http\Actions\GetSource::class]);

            $router->get('feeds', ['as' => 'feeds', 'uses' => \App\Http\Actions\GetFeedCollection::class]);
            $router->get('feeds/{id}', ['as' => 'feed', 'uses' => \App\Http\Actions\GetFeed::class]);

            $router->get('entries', ['as' => 'entries', 'uses' => \App\Http\Actions\GetEntryCollection::class]);
            $router->get('entries/{id}', ['as' => 'entry', 'uses' => \App\Http\Actions\GetEntry::class]);
        });
    }
}
