<?php

namespace App\Actions\Patient;

use App\Dtos\Patient\PatientStoreDTO;
use App\Entities\AddressEntity;
use App\Entities\PatientEntity;
use App\Exceptions\OperationException;
use App\Models\AddressModel;
use App\Models\PatientModel;
use Exception;

class PatientStoreAction
{
    public function __construct(
        protected PatientEntity $patientEntity = new PatientEntity(),
        protected PatientModel $patientModel = new PatientModel(),
        protected AddressEntity $addressEntity = new AddressEntity(),
        protected AddressModel $addressModel = new AddressModel(),
    ) {
    }

    public function execute(PatientStoreDTO $dto): bool|Exception
    {
        if ($dto->image) {
            $path = upload_image($dto->image, 'assets/images/patients');
            $dto->image = $path;
        }

        $db = db_connect();
        $db->transStart();

        $this->patientEntity->fill((array) $dto);
        $this->patientModel->save($this->patientEntity);
        $dto->patientId = $this->patientModel->getInsertID();
        $this->addressEntity->fill((array) $dto);
        $this->addressModel->save($this->addressEntity);

        if (!$db->transComplete()) {
            if (isset($dto->image)) remove_image($dto->image);
            throw new OperationException('Erro ao cadastrar paciente');
        }

        return true;
    }
}
