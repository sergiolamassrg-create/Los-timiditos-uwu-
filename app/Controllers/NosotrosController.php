<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
class NosotrosController extends Controller
{
 
    public function index()
    {

        return $this->view('pages/nosotros', []);
    }
   
   
 
}