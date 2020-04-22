<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/ifeeds'], function (Router $router) {

    $router->bind('source', function ($id) {
        return app('Modules\Ifeeds\Repositories\SourceRepository')->find($id);
    });
    $router->get('sources', [
        'as' => 'admin.ifeeds.source.index',
        'uses' => 'SourceController@index',
        'middleware' => 'can:ifeeds.sources.index'
    ]);
    $router->get('sources/create', [
        'as' => 'admin.ifeeds.source.create',
        'uses' => 'SourceController@create',
        'middleware' => 'can:ifeeds.sources.create'
    ]);
    $router->post('sources', [
        'as' => 'admin.ifeeds.source.store',
        'uses' => 'SourceController@store',
        'middleware' => 'can:ifeeds.sources.create'
    ]);
    $router->get('sources/{source}/edit', [
        'as' => 'admin.ifeeds.source.edit',
        'uses' => 'SourceController@edit',
        'middleware' => 'can:ifeeds.sources.edit'
    ]);
    $router->put('sources/{source}', [
        'as' => 'admin.ifeeds.source.update',
        'uses' => 'SourceController@update',
        'middleware' => 'can:ifeeds.sources.edit'
    ]);
    $router->delete('sources/{source}', [
        'as' => 'admin.ifeeds.source.destroy',
        'uses' => 'SourceController@destroy',
        'middleware' => 'can:ifeeds.sources.destroy'
    ]);
// append


});
