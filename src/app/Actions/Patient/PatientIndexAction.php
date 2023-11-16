<?php

namespace App\Actions\Patient;

use App\Models\PatientModel;

class PatientIndexAction
{
    public function __construct(
        private PatientModel $patientModel = new PatientModel(),
    ) {
    }

    public function execute(?string $search, ?string $searchDeleted): object
    {
        if ($search) {
            $this->patientModel->like('name', $search);
            $this->patientModel->orLike('cpf', $search);
            $this->patientModel->orLike('cns', $search);
        }

        if ($searchDeleted) $this->patientModel->onlyDeleted();

        $patients = $this->patientModel->select('id, name, cpf, cns, deleted_at')->orderBy('id')->paginate(10);

        return (object) [
            'patients' => $patients,
            'pagination' => $this->patientModel->pager,
        ];
    }
}
