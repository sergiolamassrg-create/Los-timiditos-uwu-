<?php

define('APP_ACCESS', true);

ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Core/Router.php';

$router = new App\Core\Router();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require __DIR__ . '/routes/web.php';
require __DIR__ . '/routes/api.php';

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);