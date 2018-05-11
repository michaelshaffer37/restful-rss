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

$router->get('/', ['uses' => 'IndexController@index']);

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['namespace' => 'Rss'], function () use ($router) {
        $router->get('feeds', ['uses' => 'FeedController@all']);
        $router->post('feed', ['uses' => 'FeedController@store']);
        $router->get('feed/{id}', ['as' => 'feed', 'uses' => 'FeedController@get']);

        $router->get('entries', ['uses' => 'EntryController@all']);
        $router->get('entry/{id}', ['as' => 'entry', 'uses' => 'EntryController@get']);
    });
});
