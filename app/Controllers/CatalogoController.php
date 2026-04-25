<?php

namespace App\Controllers;

use App\Core\Controller;

class CatalogoController extends Controller
{
    /**
     * Mostrar vista (osea la pagina)
     */
    public function index()
    {
      
     /**
     * El primer string es la ruta del .php de la vista (osea donde metes el html) y en el segundo datos que puedes usar dentro de esta
     * En esta funcion poder hacer llamadas a bases de datos antes de que carge la pagina pero para que se muestre siempre se tiene que usar return $this->view
     */
        return $this->view('pages/catalogo', [
    'title' => 'hola'
        ]);
    }

 
}