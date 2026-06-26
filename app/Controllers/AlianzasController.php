<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * AlianzasController
 *
 * Controlador de la página pública "Alianzas".
 * Muestra información sobre el programa de alianzas comerciales
 * con estudios de interiorismo, arquitectos y decoradores.
 *
 * Ruta asociada: GET /alianzas
 */
class AlianzasController extends Controller
{
    /**
     * Renderiza la vista de la página de alianzas.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/alianzas', []);
    }
}
