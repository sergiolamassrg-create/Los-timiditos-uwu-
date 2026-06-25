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
$router->get("/terminos","TerminosController@index");

$router->group(['prefix'=>"/admin"],function($router){
    $router->get("/login","admin/AdminController@login");
    $router->post("/login","admin/AdminController@authenticate");
    $router->post("/logout","admin/AdminController@logout");
    $router->get("","admin/AdminController@dashboard");
    $router->get("/dashboard","admin/AdminController@dashboard");
    $router->get("/catalogo","admin/AdminController@catalog");
    $router->get("/productos","admin/AdminController@products");
    $router->get("/telas","admin/AdminController@fabrics");
    $router->get("/colores","admin/AdminController@colors");
    $router->get("/combinaciones","admin/AdminController@combinations");
    $router->get("/usuarios","admin/AdminController@users");
    $router->get("/configuracion","admin/AdminController@settings");
    $router->get("/catalogo/crear","admin/AdminController@createProduct");
    $router->post("/catalogo/crear","admin/AdminController@storeProduct");
    $router->get("/catalogo/{id}/editar","admin/AdminController@editProduct");
    $router->post("/catalogo/{id}/editar","admin/AdminController@updateProduct");
    $router->post("/catalogo/{id}/estado","admin/AdminController@toggleProductStatus");
    $router->post("/catalogo/{id}/eliminar","admin/AdminController@deleteProduct");
    $router->get("/productos/crear","admin/AdminController@createProduct");
    $router->post("/productos/crear","admin/AdminController@storeProduct");
    $router->get("/productos/{id}/editar","admin/AdminController@editProduct");
    $router->post("/productos/{id}/editar","admin/AdminController@updateProduct");
    $router->post("/productos/{id}/estado","admin/AdminController@toggleProductStatus");
    $router->post("/productos/{id}/eliminar","admin/AdminController@deleteProduct");
    $router->post("/telas/crear","admin/AdminController@storeFabric");
    $router->post("/telas/{id}/editar","admin/AdminController@updateFabric");
    $router->post("/telas/{id}/eliminar","admin/AdminController@deleteFabric");
    $router->post("/colores/crear","admin/AdminController@storeColor");
    $router->post("/colores/{id}/editar","admin/AdminController@updateColor");
    $router->post("/colores/{id}/eliminar","admin/AdminController@deleteColor");
    $router->post("/tela-colores/crear","admin/AdminController@storeFabricColor");
    $router->post("/tela-colores/{id}/eliminar","admin/AdminController@deleteFabricColor");
    $router->post("/usuarios/crear","admin/AdminController@storeUser");
    $router->post("/usuarios/{id}/editar","admin/AdminController@updateUser");
    $router->post("/usuarios/{id}/eliminar","admin/AdminController@deleteUser");
    $router->post("/configuracion","admin/AdminController@updateSettings");
    $router->post("/perfil/clave","admin/AdminController@updateOwnPassword");
});



$router->get('/example',"ExampleController@index");
$router->get('/example/{id}','ExampleController@exampleID');
$router->get('/example/{id}/{TwoID}','ExampleController@exampleIDTWO');

