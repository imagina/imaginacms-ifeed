<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/ifeeds/v1'], function (Router $router) {

  require('ApiRoutes/feedRoutes.php');

});