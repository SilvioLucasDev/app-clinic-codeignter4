<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AddressEntity extends Entity
{
    protected $datamap = [
        'zipCode' => 'zip_code',
        'patientId' => 'patient_id',
        'stateId' => 'state_id',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
