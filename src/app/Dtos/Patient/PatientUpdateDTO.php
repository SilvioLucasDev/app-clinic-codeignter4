<?php

namespace App\Dtos\Patient;

use CodeIgniter\HTTP\Files\UploadedFile;

class PatientUpdateDTO
{
    public function __construct(
        public int|null $id,
        public string|UploadedFile|null $image,
        public string|null $name,
        public string|null $motherName,
        public string|null $birthDate,
        public string|null $cpf,
        public string|null $cns,
        public string|null $zipCode,
        public string|null $street,
        public int|null $number,
        public string|null $complement,
        public string|null $neighborhood,
        public string|null $city,
        public int|null $stateId,
        public int|null $patientId = null,
    ) {
    }

    public static function make(array $request): self
    {
        return new self(
            $request['id'] ?? null,
            $request['image'] ?? null,
            $request['name'] ?? null,
            $request['mother_name'] ?? null,
            $request['birth_date'] ?? null,
            $request['cpf'] ?? null,
            $request['cns'] ?? null,
            $request['zip_code'] ?? null,
            $request['street'] ?? null,
            $request['number'] ?? null,
            $request['complement'] ?? null,
            $request['neighborhood'] ?? null,
            $request['city'] ?? null,
            $request['state_id'] ?? null,
        );
    }
}
