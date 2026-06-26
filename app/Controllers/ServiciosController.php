<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * ServiciosController
 *
 * Controlador de la página pública "Servicios".
 * Muestra los servicios que ofrece Tapisur: retapizado,
 * reparación, restauración y fabricación a medida.
 *
 * Ruta asociada: GET /servicios
 */
class ServiciosController extends Controller
{
    /**
     * Renderiza la vista de la página de servicios.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/servicios', []);
    }
}
