<?php

namespace App\Actions\Patient;

use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Models\PatientModel;
use Exception;

class PatientActiveAction
{
    public function __construct(
        protected PatientModel $patientModel = new PatientModel(),
    ) {
    }

    public function execute(string $id): bool|Exception
    {
        $patient = $this->patientModel->select('id')->onlyDeleted()->find($id);
        if (!$patient) throw new PatientNotFoundException();

        $activated = $this->patientModel->update($patient->id, ['deleted_at' => null]);
        if (!$activated) throw new OperationException('Erro ao ativar o paciente');

        return true;
    }
}
