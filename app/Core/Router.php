<?php

namespace App\Core;

if (!defined('APP_ACCESS')) {
    header('HTTP/1.0 403 Forbidden');
    exit('Direct access not allowed.');
}

/**
 * Router
 *
 * Sistema de enrutamiento HTTP del proyecto.
 * Registra rutas con sus métodos (GET, POST, PUT, DELETE), soporta
 * grupos con prefijo y middlewares, y despacha el request entrante
 * al controlador correspondiente.
 *
 * Características:
 *  - Rutas con parámetros dinámicos: /recurso/{id}
 *  - Grupos con prefijo (ej: /admin) y middlewares compartidos
 *  - Dispatch basado en regex para matching de URIs
 *  - Soporte de closures y strings 'Controller@metodo'
 */
class Router
{
    /** @var array Lista de rutas registradas con method, uri, action y middlewares. */
    private array $routes = [];

    /** @var string Prefijo acumulado del grupo actual. */
    private string $groupPrefix = '';

    /** @var array Middlewares acumulados del grupo actual. */
    private array $groupMiddlewares = [];

    /**
     * Registra una ruta GET.
     *
     * @param string         $uri    Patrón de URI (ej: '/catalogo', '/productos/{id}').
     * @param string|callable $action Acción: 'Controller@metodo' o closure.
     */
    public function get($uri, $action) { $this->addRoute('GET', $uri, $action); }

    /**
     * Registra una ruta POST.
     *
     * @param string         $uri    Patrón de URI.
     * @param string|callable $action Acción a ejecutar.
     */
    public function post($uri, $action) { $this->addRoute('POST', $uri, $action); }

    /**
     * Registra una ruta PUT.
     *
     * @param string         $uri    Patrón de URI.
     * @param string|callable $action Acción a ejecutar.
     */
    public function put($uri, $action) { $this->addRoute('PUT', $uri, $action); }

    /**
     * Registra una ruta DELETE.
     *
     * @param string         $uri    Patrón de URI.
     * @param string|callable $action Acción a ejecutar.
     */
    public function delete($uri, $action) { $this->addRoute('DELETE', $uri, $action); }

    /**
     * Define un grupo de rutas con atributos compartidos.
     *
     * Permite agrupar rutas bajo un prefijo común y/o middlewares
     * que se aplican a todas las rutas dentro del grupo.
     *
     * @param array    $attributes Atributos del grupo:
     *                             - 'prefix': string con prefijo de URI (ej: '/admin')
     *                             - 'middlewares': array de clases middleware
     * @param callable $callback   Closure que recibe $this y registra rutas del grupo.
     */
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

    /**
     * Agrega una ruta al registro interno.
     *
     * Combina el prefijo de grupo actual con la URI proporcionada
     * y almacena la ruta con sus middlewares asociados.
     *
     * @param string         $method Método HTTP (GET, POST, PUT, DELETE).
     * @param string         $uri    Patrón de URI relativa al grupo.
     * @param string|callable $action Acción a ejecutar.
     */
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

    /**
     * Despacha el request entrante a la ruta coincidente.
     *
     * Proceso:
     *  1. Extrae el path del REQUEST_URI.
     *  2. Remueve el base path (para soportar subdirectorios).
     *  3. Itera las rutas buscando coincidencia por método y patrón.
     *  4. Ejecuta middlewares del grupo si hay match.
     *  5. Llama a execute() con la acción y parámetros capturados.
     *  6. Retorna 404 si no hay coincidencia.
     *
     * @param string $requestUri    URI completa del request ($_SERVER['REQUEST_URI']).
     * @param string $requestMethod Método HTTP ($_SERVER['REQUEST_METHOD']).
     *
     * @return mixed Resultado de la acción ejecutada, o respuesta 404.
     */
    public function dispatch($requestUri, $requestMethod)
    {
        $path = parse_url($requestUri, PHP_URL_PATH);
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        $basePath = $basePath === '.' ? '' : $basePath;

        if ($basePath !== '' && strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath)) ?: '/';
        }

        if (strpos($path, '/index.php') === 0) {
            $path = substr($path, 10) ?: '/';
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

    /**
     * Ejecuta la acción de una ruta.
     *
     * Soporta dos formatos:
     *  - Callable (closure): lo invoca directamente con los parámetros.
     *  - String 'Controller@metodo': instancia el controlador y llama al método.
     *
     * @param string|callable $action Acción a ejecutar.
     * @param array           $params Parámetros capturados de la URI (ej: {id}).
     *
     * @return mixed Resultado del controlador o closure.
     *
     * @throws \Exception Si el controlador o método no existen.
     */
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
