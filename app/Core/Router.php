<?php

namespace App\Core;
if (!defined('APP_ACCESS')) {
    header('HTTP/1.0 403 Forbidden');
    exit('Direct access not allowed.');
}
class Router
{
    private array $routes = [];
    private string $groupPrefix = '';
    private array $groupMiddlewares = [];

    public function get($uri, $action) { $this->addRoute('GET', $uri, $action); }
    public function post($uri, $action) { $this->addRoute('POST', $uri, $action); }
    public function put($uri, $action) { $this->addRoute('PUT', $uri, $action); }
    public function delete($uri, $action) { $this->addRoute('DELETE', $uri, $action); }

 
    public function group(array $attributes, callable $callback)
    {
        $previousPrefix = $this->groupPrefix;
        $previousMiddlewares = $this->groupMiddlewares;

        if (isset($attributes['prefix'])) {
            $this->groupPrefix .= $attributes['prefix'];
        }


        if (isset($attributes['middlewares'])) {
            $this->groupMiddlewares = array_merge($this->groupMiddlewares, $attributes['middlewares']);
        }

   
        $callback($this);

    
        $this->groupPrefix = $previousPrefix;
        $this->groupMiddlewares = $previousMiddlewares;
    }

    private function addRoute($method, $uri, $action)
    {
 
        $fullUri = rtrim($this->groupPrefix . $uri, '/');
        $fullUri = $fullUri === '' ? '/' : $fullUri;

        $this->routes[] = [
            'method' => $method,
            'uri' => $fullUri,
            'action' => $action,
            'middlewares' => $this->groupMiddlewares
        ];
    }

    public function dispatch($requestUri, $requestMethod)
{
    $path = parse_url($requestUri, PHP_URL_PATH);

    if (strpos($path, '/index.php') === 0) {
        $path = substr($path, 10);
    }

    $path = rtrim($path, '/');
    $path = $path === '' ? '/' : $path;

  foreach ($this->routes as $route) {

    if ($route['method'] !== $requestMethod) continue;

   
    if ($route['uri'] === '/' && $path === '/') {
        return $this->execute($route['action']);
    }

   
    $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route['uri']);
    $pattern = "#^" . rtrim($pattern, '/') . "$#";

    if (preg_match($pattern, $path, $matches)) {

        array_shift($matches);

        foreach ($route['middlewares'] as $middlewareClass) {
            (new $middlewareClass())->handle();
        }

        return $this->execute($route['action'], $matches);
    }
}

    http_response_code(404);
    echo "404 Not Found: " . htmlspecialchars($path);
}
    private function execute($action, $params = [])
{
    if (is_callable($action)) {
        return $action(...$params);
    }

    if (is_string($action)) {
        [$controllerName, $method] = explode('@', $action);
        
        $controllerClass = "App\\Controllers\\" . str_replace('/', '\\', $controllerName);

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller [$controllerClass] not found");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new \Exception("Method [$method] not found in $controllerClass");
        }

        return $controller->$method(...$params);
    }
}
}