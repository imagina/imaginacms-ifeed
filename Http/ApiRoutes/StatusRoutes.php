<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'statuses'], function (Router $router) {
  $router->get('/', [
    'as' => 'api.ifeeds.status.index',
    'uses' => 'StatusApiController@index',
  ]);
});
