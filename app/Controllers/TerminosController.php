<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * TerminosController
 *
 * Controlador de la página pública "Términos y Condiciones".
 * Muestra las condiciones generales de contratación,
 * responsabilidades y derechos del usuario.
 *
 * Ruta asociada: GET /terminos
 */
class TerminosController extends Controller
{
    /**
     * Renderiza la vista de la página de términos y condiciones.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/terminos', []);
    }
}
