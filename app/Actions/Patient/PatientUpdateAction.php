<?php

namespace App\Actions\Patient;

use App\Dtos\Patient\PatientUpdateDTO;
use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Models\AddressModel;
use App\Models\PatientModel;
use Exception;

class PatientUpdateAction
{
    public function __construct(
        protected PatientModel $patientModel = new PatientModel(),
        protected AddressModel $addressModel = new AddressModel(),
    ) {
    }

    public function execute(PatientUpdateDTO $dto): bool|Exception
    {
        $patient = $this->patientModel->select('patients.id, patients.image, addresses.id AS address_id')
            ->join('addresses', 'addresses.patient_id = patients.id')
            ->find($dto->id);

        if (!$patient) throw new PatientNotFoundException();

        if ($dto->image) {
            $path = upload_image($dto->image, 'assets/images/patients');
            if (isset($patient->image)) remove_image($patient->image);
            $dto->image = $path;
        }

        if (isset($dto->image)) $patientData['image'] = $dto->image;
        if (isset($dto->name)) $patientData['name'] = $dto->name;
        if (isset($dto->birthDate)) $patientData['birthDate'] = $dto->birthDate;
        if (isset($dto->birthDate)) $patientData['birthDate'] = $dto->birthDate;
        if (isset($dto->cpf)) $patientData['cpf'] = $dto->cpf;
        if (isset($dto->cns)) $patientData['cns'] =  $dto->cns;

        if (isset($dto->zipCode)) $addressData['zipCode'] = $dto->zipCode;
        if (isset($dto->street)) $addressData['street'] = $dto->street;
        if (isset($dto->number)) $addressData['number'] = $dto->number;
        if (isset($dto->neighborhood)) $addressData['neighborhood'] = $dto->neighborhood;
        if (isset($dto->city)) $addressData['city'] = $dto->city;
        if (isset($dto->stateId)) $addressData['stateId'] = $dto->stateId;

        $db = db_connect();
        $db->transStart();

        if (isset($patientData)) $this->patientModel->update($patient->id, $patientData);
        if (isset($addressData)) $this->addressModel->update($patient->address_id, $addressData);

        if (!$db->transComplete()) {
            if (isset($dto->image)) remove_image($dto->image);
            throw new OperationException('Erro ao atualizar os dados do paciente');
        }

        return true;
    }
}
