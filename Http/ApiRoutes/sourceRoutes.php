<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/sources'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.ifeeds.sources.create',
    'uses' => 'SourceApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ifeeds.sources.get.items.by',
    'uses' => 'SourceApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ifeeds.sources.get.item',
    'uses' => 'SourceApiController@show',
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ifeeds.sources.update',
    'uses' => 'SourceApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ifeeds.sources.delete',
    'uses' => 'SourceApiController@delete',
    'middleware' => ['auth:api']
  ]);


});
