<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\Database;
class AdminController extends Controller
{
    /**
     * Mostrar vista (osea la pagina)
     */
    public function login()
    {
     /**
     * El primer string es la ruta del .php de la vista (osea donde metes el html) y en el segundo datos que puedes usar dentro de esta
     * En esta funcion poder hacer llamadas a bases de datos antes de que carge la pagina pero para que se muestre siempre se tiene que usar return $this->view
     */
        return $this->view('pages/admin/adminLogin', []);
    }
   
   
 
}