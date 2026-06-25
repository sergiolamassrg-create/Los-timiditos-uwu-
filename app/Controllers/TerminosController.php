<?php

namespace App\Controllers;

use App\Core\Controller;

class TerminosController extends Controller
{
    public function index()
    {
        return $this->view('pages/terminos', [
            'title' => 'Términos y Condiciones'
        ]);
    }
}