<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PatientEntity extends Entity
{
    protected $datamap = [
        'motherName' => 'mother_name',
        'birthDate' => 'birth_date',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
