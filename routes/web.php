<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * @var $router \Laravel\Lumen\Routing\Router
 */
$router->get('/', ['uses' => 'IndexController@index']);

$router->group(['prefix' => 'api'], function (\Laravel\Lumen\Routing\Router $router) {
    $router->group(['namespace' => 'Rss'], function (\Laravel\Lumen\Routing\Router $router) {
        $router->get('feeds', ['as' => 'feed.collection', 'uses' => 'FeedController@all']);
        $router->post('feeds', ['uses' => 'FeedController@store']);
        $router->get('feeds/{id}', ['as' => 'feed', 'uses' => 'FeedController@get']);

        $router->get('entries', ['as' => 'entry.collection', 'uses' => 'EntryController@all']);
        $router->get('entries/{id}', ['as' => 'entry', 'uses' => 'EntryController@get']);
    });
});
