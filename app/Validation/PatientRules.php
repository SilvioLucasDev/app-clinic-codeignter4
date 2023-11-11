<?php

namespace App\Validation;

use App\Models\PatientModel;

class PatientRules
{
    public function cpf_is_unique(string $cpf, ?string &$error = null): bool
    {
        $patientModel = new PatientModel();
        $patient = $patientModel->where('cpf', sanitize_number($cpf))->first();
        $error = 'O CPF fornecido já cadastrado no sistema';
        return $patient === null ? true : false;
    }

    public function cns_is_unique(string $cns, ?string &$error = null): bool
    {
        $patientModel = new PatientModel();
        $patient = $patientModel->where('cns', sanitize_number($cns))->first();
        $error = 'O CNS fornecido já cadastrado no sistema';
        return $patient === null ? true : false;
    }
}
