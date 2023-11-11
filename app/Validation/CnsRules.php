<?php

namespace App\Validation;

class  CnsRules
{
    /**
     *  Function to validate national health card (CNS)
     */
    public function cns_is_valid(string $cns, ?string &$error = null): bool
    {
        $error = 'O CNS fornecido é inválido';

        $cns = sanitize_number($cns);
        if (strlen($cns) != 15) {
            return false;
        }

        if (in_array(substr($cns, 0, 1), ['1', '2'])) {
            if (!$this->validate_cns($cns)) {
                return false;
            }
        } elseif (in_array(substr($cns, 0, 1), ['7', '8', '9'])) {
            if (!$this->valida_cns_prov($cns)) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     *  Function to validate if cns starts with 1 and 2
     */
    private function validate_cns(string $cns): bool
    {

        $pis = substr($cns, 0, 11);
        $soma = 0;
        for ($i = 0; $i < 11; $i++) {
            $soma += (int) substr($pis, $i, 1) * (15 - $i);
        }

        $dv = 11 - ($soma % 11);
        if ($dv == 11) {
            $dv = 0;
        }

        if ($dv == 10) {
            $soma = 0;
            for ($i = 0; $i < 11; $i++) {
                $soma += (int) substr($pis, $i, 1) * (15 - $i);
            }
            $soma += 2;
            $dv = 11 - ($soma % 11);
            return $cns == $pis . '001' . $dv;
        }

        return $cns == $pis . '000' . $dv;
    }

    /**
     *  Function to validate if cns starts with 7, 8 or 9
     */
    private function valida_cns_prov(string $cns): bool
    {
        $soma = 0;
        for ($i = 0; $i < 15; $i++) {
            $soma += (int) substr($cns, $i, 1) * (15 - $i);
        }

        return $soma % 11 == 0;
    }
}
