<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * ContactoController
 *
 * Controlador de la página pública "Contacto".
 * Muestra información de contacto (teléfonos, dirección, horarios),
 * enlace a WhatsApp e Instagram, y mapa de ubicación.
 *
 * Ruta asociada: GET /contacto
 */
class ContactoController extends Controller
{
    /**
     * Renderiza la vista de la página de contacto.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/contacto', []);
    }
}
