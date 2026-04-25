<?php

use App\Core\Router;

/** @var Router $router */

$router->get('/api/posts', 'Api\PostController@index');
$router->post('/api/posts', 'Api\PostController@store');
