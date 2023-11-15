<?php

namespace App\Dtos\Patient;

use CodeIgniter\HTTP\Files\UploadedFile;

class PatientStoreDTO
{
    public function __construct(
        public string|UploadedFile|null $image,
        public string $name,
        public string $motherName,
        public string $birthDate,
        public string $cpf,
        public string $cns,
        public string $zipCode,
        public string $street,
        public int|null $number,
        public string|null $complement,
        public string $neighborhood,
        public string $city,
        public int $stateId,
        public int|null $patientId = null,

    ) {
    }

    public static function make(array $request): self
    {
        return new self(
            $request['image'],
            $request['name'],
            $request['mother_name'],
            $request['birth_date'],
            $request['cpf'],
            $request['cns'],
            $request['zip_code'],
            $request['street'],
            $request['number'],
            $request['complement'] ?? null,
            $request['neighborhood'],
            $request['city'],
            $request['state_id'],
        );
    }
}
