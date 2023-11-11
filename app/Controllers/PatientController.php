<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\StateModel;

class PatientController extends BaseController
{
    public function index(): string
    {
        $patient = new PatientModel();
        if ($search = $this->request->getVar('search')) {
            $patient->like('name', $search);
            $patient->orLike('cpf', $search);
            $patient->orLike('cns', $search);
        }
        $patients = $patient->select('id, name, cpf, cns')->paginate(10);

        return view('patient/index', [
            'patients' => $patients,
            'pager' => $patient->pager,
        ]);
    }

    public function create(): string
    {
        $state = new StateModel();
        $states = $state->findAll();

        return view('patient/create', [
            'states' => $states
        ]);
    }
}
