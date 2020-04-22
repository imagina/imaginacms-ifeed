<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/ifeeds/v1'], function (Router $router) {

  require('ApiRoutes/feedRoutes.php');

  require('ApiRoutes/sourceRoutes.php');

  require('ApiRoutes/TypeRoutes.php');

  require('ApiRoutes/StatusRoutes.php');

});