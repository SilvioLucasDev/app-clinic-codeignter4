<?php

namespace App\Actions\Patient;

use App\Dtos\Patient\PatientUpdateDTO;
use App\Entities\AddressEntity;
use App\Entities\PatientEntity;
use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Models\AddressModel;
use App\Models\PatientModel;
use Exception;

class PatientUpdateAction
{
    public function __construct(
        private PatientEntity $patientEntity = new PatientEntity(),
        private PatientModel $patientModel = new PatientModel(),
        private AddressEntity $addressEntity = new AddressEntity(),
        private AddressModel $addressModel = new AddressModel(),
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

        $patientData = [
            'image' => $dto->image,
            'name' => $dto->name,
            'motherName' => $dto->motherName,
            'birthDate' => $dto->birthDate,
            'cpf' => $dto->cpf,
            'cns' => $dto->cns,
        ];

        $addressData = [
            'zipCode' => $dto->zipCode,
            'street' => $dto->street,
            'number' => $dto->number,
            'neighborhood' => $dto->neighborhood,
            'city' => $dto->city,
            'stateId' => $dto->stateId,
        ];

        $patientData = $this->removeIfNull($patientData);
        $addressData = $this->removeIfNull($addressData);

        $db = db_connect();
        $db->transStart();

        if (!empty($patientData)) {
            $this->patientEntity->fill($patientData);
            $this->patientModel->update($patient->id, $this->patientEntity);
        }

        if (!empty($addressData)) {
            $this->addressEntity->fill($addressData);
            $this->addressModel->update($patient->address_id, $this->addressEntity);
        }

        if (!$db->transComplete()) {
            if (isset($dto->image)) remove_image($dto->image);
            throw new OperationException('Erro ao atualizar os dados do paciente');
        }
        return true;
    }

    private function removeIfNull(array $array): array
    {
        return array_filter($array, fn ($item) => $item !== null);
    }
}
