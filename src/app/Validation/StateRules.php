<?php

namespace App\Validation;

use App\Models\StateModel;

class StateRules
{
    public function is_valid_state_id(int $id, ?string &$error = null): bool
    {
        $stateModel = new StateModel();
        $state = $stateModel->find($id);
        $error = 'O estado fornecido é inválido';
        return $state === null ? false : true;
    }
}
