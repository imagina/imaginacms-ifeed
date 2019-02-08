<?php

use Illuminate\Routing\Router;
/** @var Router $router

$router->group(['prefix' => 'feed'], function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('{format}', [
        'as' => $locale . '.ifeed.feed.format',
        'uses' => 'PublicController@feed',

    ]);
});
*/