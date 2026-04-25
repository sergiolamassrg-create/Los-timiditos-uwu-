<?php

namespace App\Controllers;

use App\Core\Controller;

class ExampleController extends Controller
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
        return $this->view('pages/example', [
            'title' => 'Página de ejemplo'
        ]);
    }
    public function exampleID($id){
        // una peticion a la base de datos
          return $this->view('pages/exampleID', [
            'id' => $id,
            "titulo"=>"titulo 1dddddddddd"
        ]);
    }
 public function exampleIDTWO($id,$TwoID){
    
          return $this->view('pages/exampleIDTWO', [
            'id' => $id,
            "idTwo" =>$TwoID
        ]);
    }
   
 
}