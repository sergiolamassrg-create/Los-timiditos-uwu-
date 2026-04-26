<?php


use App\Core\Router;

/** @var Router $router */

$router->get('/','HomeController@index');

$router->get('/catalogo','CatalogoController@index');
$router->get('/alianzas',"AlianzasController@index");
$router->get('/contacto','ContactoController@index');
$router->get('/entregas','EntregasController@index');
$router->get("/garantia",'GarantiaController@index');
$router->get("/nosotros","NosotrosController@index");
$router->get("/servicios","ServiciosController@index");

$router->group(['prefix'=>"/admin"],function($router){
    $router->get("/login","admin/AdminController@login");
});



$router->get('/example',"ExampleController@index");
$router->get('/example/{id}','ExampleController@exampleID');
$router->get('/example/{id}/{TwoID}','ExampleController@exampleIDTWO');




