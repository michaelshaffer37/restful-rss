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

$router->get('hello', ['uses' => 'IndexController@hello']);

$router->get('rss-test', ['uses' => 'RssController@rssTest']);

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'rss', 'namespace' => 'Rss'], function () use ($router) {
        $router->post('feed', ['uses' => 'FeedController@storeFeed']);
        $router->get('feed/{feed}', ['uses' => 'FeedController@getFeed']);
    });
});
