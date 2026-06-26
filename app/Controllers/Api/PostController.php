<?php

namespace App\Controllers\Api;

use App\Core\Controller;

/**
 * PostController (API)
 *
 * Controlador de ejemplo para endpoints REST en formato JSON.
 * Demuestra el uso del método json() de la clase base Controller.
 *
 * Rutas asociadas:
 *   GET  /api/posts → index()
 *   POST /api/posts → store() (pendiente de implementación)
 */
class PostController extends Controller
{
    /**
     * Devuelve un listado de posts de ejemplo en formato JSON.
     *
     * @return void Emite respuesta JSON con status 200.
     */
    public function index()
    {
        return $this->json([
            ['id' => 1, 'title' => 'Post 1'],
            ['id' => 2, 'title' => 'Post 2']
        ]);
    }
}
