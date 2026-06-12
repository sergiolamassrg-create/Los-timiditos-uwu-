<?php

namespace App\Core;

class Controller
{
    protected function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

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
