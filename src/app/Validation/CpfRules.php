<?php

namespace App\Validation;

class  CpfRules
{
    /**
     *  Function to validate individual registration (CPF)
     */
    public function cpf_is_valid(string $cpf, ?string &$error = null): bool
    {
        $error = 'O CPF fornecido é inválido';

        $cpf = sanitize_number($cpf);
        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = (10 * $d) % 11 % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
