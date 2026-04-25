<?php

namespace App\Controllers\Api;

use App\Core\Controller;

class PostController extends Controller
{
    public function index()
    {
        return $this->json([
            ['id' => 1, 'title' => 'Post 1'],
            ['id' => 2, 'title' => 'Post 2']
        ]);
    }

  
}