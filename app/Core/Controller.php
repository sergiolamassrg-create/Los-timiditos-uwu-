<?php

namespace App\Core;

/**
 * Controller (Base)
 *
 * Clase base de la que extienden todos los controladores del proyecto.
 * Provee métodos utilitarios para renderizar vistas HTML y emitir
 * respuestas JSON.
 *
 * Responsabilidades:
 *  - Renderizar templates PHP con inyección de datos.
 *  - Reescribir paths relativos según el base path de la aplicación.
 *  - Inyectar la variable global `window.__APP_BASE_PATH__` para JS.
 *  - Emitir respuestas JSON con status code configurable.
 */
class Controller
{
    /**
     * Emite una respuesta JSON.
     *
     * Establece el header Content-Type como application/json,
     * configura el código HTTP y envía los datos codificados.
     *
     * @param mixed $data   Datos a serializar como JSON.
     * @param int   $status Código de respuesta HTTP (default: 200).
     *
     * @return void
     */
    protected function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Renderiza una vista PHP y emite el HTML resultante.
     *
     * Proceso:
     *  1. Extrae $data como variables locales para el template.
     *  2. Renderiza el archivo de vista usando output buffering.
     *  3. Calcula el base path de la aplicación.
     *  4. Reescribe atributos href, src y action para que funcionen
     *     correctamente en subdirectorios.
     *  5. Inyecta un script con `window.__APP_BASE_PATH__` antes de </head>.
     *
     * @param string $view Ruta relativa a la vista (sin extensión .php),
     *                     por ejemplo: 'pages/home', 'pages/admin/index'.
     * @param array  $data Datos a pasar a la vista como variables extraídas.
     *
     * @return void
     */
    protected function view($view, $data = [])
    {
        extract($data);
        ob_start();
        require __DIR__ . "/../../views/$view.php";
        $html = ob_get_clean();

        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        $basePath = $basePath === '.' ? '' : $basePath;

        if ($basePath !== '') {
            $html = preg_replace('/\b(href|src)="\/(?!\/)/', '$1="' . $basePath . '/', $html);
            $html = preg_replace('/\b(action)="\/(?!\/)/', '$1="' . $basePath . '/', $html);
        }

        $baseScript = '<script>window.__APP_BASE_PATH__ = ' . json_encode($basePath) . ';</script>';
        $html = preg_replace('/<\/head>/i', $baseScript . "\n</head>", $html, 1);

        echo $html;
    }
}
