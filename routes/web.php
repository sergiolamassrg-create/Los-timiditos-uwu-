<?php


use App\Core\Router;

/** @var Router $router */

$router->get('/','HomeController@index');
$router->get('/example',"ExampleController@index");
$router->get('/catalogo','CatalogoController@index');
$router->get('/example/{id}','ExampleController@exampleID');
$router->get('/example/{id}/{TwoID}','ExampleController@exampleIDTWO');




