<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
class ServiciosController extends Controller
{
 
    public function index()
    {

        return $this->view('pages/servicios', []);
    }
   
}
  