<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * NosotrosController
 *
 * Controlador encargado de la página pública "Nosotros".
 * Muestra información institucional sobre Tapisur: historia,
 * valores, equipo y filosofía de trabajo.
 *
 * Ruta asociada: GET /nosotros
 */
class NosotrosController extends Controller
{
    /**
     * Renderiza la vista de la página "Nosotros".
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/nosotros', []);
    }
}
