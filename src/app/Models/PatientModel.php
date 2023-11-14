<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table            = 'patients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'image',
        'name',
        'mother_name',
        'birth_date',
        'cpf',
        'cns',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['sanitizeFields'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['sanitizeFields'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function sanitizeFields(array $data): array
    {
        if (isset($data['data']['cpf']))  $data['data']['cpf'] = sanitize_number($data['data']['cpf']);
        if (isset($data['data']['cns'])) $data['data']['cns'] = sanitize_number($data['data']['cns']);

        return $data;
    }
}
