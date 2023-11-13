<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index(): string
    {
        return view('home');
    }
}
