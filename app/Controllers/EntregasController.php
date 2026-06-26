<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * EntregasController
 *
 * Controlador de la página pública "Entregas".
 * Muestra las políticas de entrega, zonas de cobertura,
 * tiempos estimados y condiciones de envío.
 *
 * Ruta asociada: GET /entregas
 */
class EntregasController extends Controller
{
    /**
     * Renderiza la vista de la página de entregas.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/entregas', []);
    }
}
