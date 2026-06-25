<?php

namespace App\Controllers;

use App\Core\Controller;

class PrivacidadController extends Controller
{
    public function index()
    {
        return $this->view('pages/privacidad', []);
    }
}
