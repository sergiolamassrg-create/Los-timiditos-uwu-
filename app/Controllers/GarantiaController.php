<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * GarantiaController
 *
 * Controlador de la página pública "Garantía".
 * Muestra las condiciones de garantía que Tapisur ofrece
 * sobre sus productos y servicios.
 *
 * Ruta asociada: GET /garantia
 */
class GarantiaController extends Controller
{
    /**
     * Renderiza la vista de la página de garantía.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/garantia', []);
    }
}
