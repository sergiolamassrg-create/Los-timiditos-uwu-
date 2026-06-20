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
    $router->post("/login","admin/AdminController@authenticate");
    $router->post("/logout","admin/AdminController@logout");
    $router->get("","admin/AdminController@dashboard");
    $router->get("/catalogo","admin/AdminController@catalog");
    $router->get("/catalogo/crear","admin/AdminController@createProduct");
    $router->post("/catalogo/crear","admin/AdminController@storeProduct");
    $router->get("/catalogo/{id}/editar","admin/AdminController@editProduct");
    $router->post("/catalogo/{id}/editar","admin/AdminController@updateProduct");
    $router->post("/catalogo/{id}/eliminar","admin/AdminController@deleteProduct");
    $router->post("/telas/crear","admin/AdminController@storeFabric");
    $router->post("/telas/{id}/editar","admin/AdminController@updateFabric");
    $router->post("/telas/{id}/eliminar","admin/AdminController@deleteFabric");
    $router->post("/colores/crear","admin/AdminController@storeColor");
    $router->post("/colores/{id}/editar","admin/AdminController@updateColor");
    $router->post("/colores/{id}/eliminar","admin/AdminController@deleteColor");
    $router->post("/tela-colores/crear","admin/AdminController@storeFabricColor");
    $router->post("/tela-colores/{id}/eliminar","admin/AdminController@deleteFabricColor");
});



$router->get('/example',"ExampleController@index");
$router->get('/example/{id}','ExampleController@exampleID');
$router->get('/example/{id}/{TwoID}','ExampleController@exampleIDTWO');


