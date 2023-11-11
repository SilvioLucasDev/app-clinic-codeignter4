<?php

namespace Config;

use App\Validation\PatientRules;
use App\Validation\StateRules;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        StateRules::class,
        PatientRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public array $patient_store = [
        'image' => [
            'label' => 'Foto',
            'rules' => 'is_image[image]|ext_in[image,png,jpg,gif]'
        ],
        'name' => [
            'label' => 'Nome', 'rules' => 'required|min_length[3]|max_length[100]'
        ],
        'mother_name' => [
            'label' => 'Nome da Mãe', 'rules' => 'required|min_length[3]|max_length[100]'
        ],
        'birth_date'  => [
            'label' => 'Dt. Nascimento', 'rules' => 'required|valid_date[Y-m-d]'
        ],
        'cpf' => [
            'label' => 'CPF', 'rules' => 'required|min_length[14]|max_length[14]|cpf_is_unique'
        ],
        'cns'  => [
            'label' => 'CNS', 'rules' => 'required|min_length[18]|max_length[18]|cns_is_unique'
        ],
        'zipcode' => [
            'label' => 'CEP', 'rules' => 'required|min_length[9]|max_length[9]'
        ],
        'street' => [
            'label' => 'Rua', 'rules' => 'required|min_length[3]|max_length[100]'
        ],
        'number' => [
            'label' => 'Número', 'rules' => 'required|numeric|max_length[10]'
        ],
        'complement' => [
            'label' => 'Complemento', 'rules' => 'max_length[100]'
        ],
        'neighborhood' => [
            'label' => 'Bairro', 'rules' => 'required|min_length[3]|max_length[100]'
        ],
        'city' => [
            'label' => 'Cidade', 'rules' => 'required|min_length[3]|max_length[100]'
        ],
        'state_id' => [
            'label' => 'Estado', 'rules' => 'required|is_valid_state_id'
        ],
    ];
}
