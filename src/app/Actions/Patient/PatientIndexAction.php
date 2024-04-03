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
        $this->patientModel->select('id, name, cpf, cns, deleted_at');

        if ($search) {
            $this->patientModel->groupStart();
            $this->patientModel->like('name', $search, 'both', null, true);
            $this->patientModel->orLike('cpf', preg_replace('/[\.\-\s]/', '', $search));
            $this->patientModel->orLike('cns', preg_replace('/[\.\-\s]/', '', $search));
            $this->patientModel->groupEnd();
        }

        if ($searchDeleted) $this->patientModel->onlyDeleted();

        $patients = $this->patientModel->orderBy('id')->paginate(10);

        return (object) [
            'patients' => $patients,
            'pagination' => $this->patientModel->pager,
        ];
    }
}
