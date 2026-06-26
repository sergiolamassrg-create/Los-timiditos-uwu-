<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * HomeController
 *
 * Controlador de la página principal (landing) del sitio público.
 * Muestra hero, beneficios, proceso de trabajo, trabajos realizados
 * y sección de contacto rápido por WhatsApp.
 *
 * Ruta asociada: GET /
 */
class HomeController extends Controller
{
    /**
     * Renderiza la vista de la página de inicio.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/home', [
            'title' => 'Mi CMS'
        ]);
    }
}
