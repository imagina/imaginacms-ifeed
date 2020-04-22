<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/feeds'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->get('/', [
    'as' => $locale . 'api.ifeeds.feed.index',
    'uses' => 'FeedApiController@index',
  ]);

});