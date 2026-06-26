<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * PrivacidadController
 *
 * Controlador de la página pública "Política de Privacidad".
 * Muestra los términos de uso de datos personales y
 * política de cookies del sitio.
 *
 * Ruta asociada: GET /privacidad
 */
class PrivacidadController extends Controller
{
    /**
     * Renderiza la vista de la página de privacidad.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/privacidad', []);
    }
}
