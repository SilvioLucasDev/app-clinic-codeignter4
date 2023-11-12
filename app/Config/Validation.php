<?php

namespace Config;

use App\Validation\CnsRules;
use App\Validation\CpfRules;
use App\Validation\StateRules;
use App\Validation\CustomRules;
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
        CustomRules::class,
        StateRules::class,
        CnsRules::class,
        CpfRules::class
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
            'label' => 'Foto', 'rules' => 'is_image[image]|ext_in[image,png,jpg,jpeg]'
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
            'label' => 'CPF', 'rules' => 'required|min_length[11]|max_length[14]|cpf_is_valid|is_unique_custom[patients.cpf]'
        ],
        'cns'  => [
            'label' => 'CNS', 'rules' => 'required|min_length[15]|max_length[18]|cns_is_valid|is_unique_custom[patients.cns]'
        ],
        'zip_code' => [
            'label' => 'CEP', 'rules' => 'required|min_length[8]|max_length[9]'
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
            'label' => 'Estado', 'rules' => 'required|numeric|is_valid_state_id'
        ],
    ];

    public array $patient_update = [
        'id' => [
            'rules' => 'required_with[cpf,cns]'
        ],
        'image' => [
            'label' => 'Foto', 'rules' => 'if_exist|is_image[image]|ext_in[image,png,jpg,gif]'
        ],
        'name' => [
            'label' => 'Nome', 'rules' => 'if_exist|min_length[3]|max_length[100]'
        ],
        'mother_name' => [
            'label' => 'Nome da Mãe', 'rules' => 'if_exist|min_length[3]|max_length[100]'
        ],
        'birth_date'  => [
            'label' => 'Dt. Nascimento', 'rules' => 'if_exist|valid_date[Y-m-d]'
        ],
        'cpf' => [
            'label' => 'CPF', 'rules' => 'if_exist|min_length[11]|max_length[14]|cpf_is_valid|is_unique_custom[patients.cpf,id,{id}]'
        ],
        'cns'  => [
            'label' => 'CNS', 'rules' => 'if_exist|min_length[15]|max_length[18]|cns_is_valid|is_unique_custom[patients.cns,id,{id}]'
        ],
        'zip_code' => [
            'label' => 'CEP', 'rules' => 'if_exist|min_length[8]|max_length[9]'
        ],
        'street' => [
            'label' => 'Rua', 'rules' => 'if_exist|min_length[3]|max_length[100]'
        ],
        'number' => [
            'label' => 'Número', 'rules' => 'if_exist|numeric|max_length[10]'
        ],
        'complement' => [
            'label' => 'Complemento', 'rules' => 'if_exist|max_length[100]'
        ],
        'neighborhood' => [
            'label' => 'Bairro', 'rules' => 'if_exist|min_length[3]|max_length[100]'
        ],
        'city' => [
            'label' => 'Cidade', 'rules' => 'if_exist|min_length[3]|max_length[100]'
        ],
        'state_id' => [
            'label' => 'Estado', 'rules' => 'if_exist|numeric|is_valid_state_id'
        ],
    ];
}
