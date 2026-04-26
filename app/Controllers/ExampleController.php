<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
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
        $db = Database::connect();
        $stmt = $db->prepare("Select * from sofas where id = ?");
        $stmt->execute([$id]);
          return $this->view('pages/exampleID', [
            'id' => $id,
            "datos"=>$stmt->fetchAll()
        ]);
    }
 public function exampleIDTWO($id,$TwoID){
         
          return $this->view('pages/exampleIDTWO', [
            'id' => $id,
            "idTwo" =>$TwoID
        ]);
    }
   
 
}