<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'types'], function (Router $router) {
  $router->get('/', [
    'as' => 'api.ifeeds.types.index',
    'uses' => 'TypeApiController@index',
  ]);
});
