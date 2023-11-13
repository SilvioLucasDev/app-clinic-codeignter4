<?php

namespace App\Actions\Patient;

use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Models\PatientModel;
use Exception;

class PatientDestroyAction
{
    public function __construct(
        protected PatientModel $patientModel = new PatientModel(),
    ) {
    }

    public function execute(string $id): bool|Exception
    {
        $patient = $this->patientModel->select('id')->find($id);
        if (!$patient) throw new PatientNotFoundException();

        $deleted = $this->patientModel->delete($patient->id);
        if (!$deleted) throw new OperationException('Erro ao deletar o paciente');

        return true;
    }
}
