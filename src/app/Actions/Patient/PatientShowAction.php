<?php

namespace App\Actions\Patient;

use App\Exceptions\PatientNotFoundException;
use App\Models\PatientModel;

class PatientShowAction
{
    public function __construct(
        protected PatientModel $patientModel = new PatientModel(),
    ) {
    }

    public function execute(string $id): object
    {
        $patient = $this->patientModel->select('
                patients.id, patients.image, patients.name, patients.mother_name, patients.birth_date, patients.cpf, patients.cns,
                addresses.zip_code, addresses.street, addresses.number, addresses.complement, addresses.neighborhood, addresses.city, addresses.state_id
            ')
            ->join('addresses', 'addresses.patient_id = patients.id')
            ->join('states', 'states.id = addresses.state_id')
            ->find($id);

        if (!$patient) throw new PatientNotFoundException();

        return $patient;
    }
}
