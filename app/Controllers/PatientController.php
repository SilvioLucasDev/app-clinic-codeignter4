<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PatientController extends BaseController
{
    public function index(): string
    {
        return view('patient/index');
    }
}
