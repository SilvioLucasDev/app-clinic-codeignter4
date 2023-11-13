<?php

namespace App\Validation;

use Config\Database;

class CustomRules
{
    /**
     * Sanitize field and checks the database to see if the given value is unique. Can
     * ignore a single record by field/value to make it useful during
     * record updates.
     *
     * Example:
     *    is_unique[table.field,ignore_field,ignore_value]
     *    is_unique[users.email,id,5]
     *
     * @param array|bool|float|int|object|string|null $str
     */
    public function is_unique_custom($str, string $field, array $data, &$error = null): bool
    {
        if (is_object($str) || is_array($str)) {
            return false;
        }

        $str = sanitize_number($str);

        [$field, $ignoreField, $ignoreValue] = array_pad(
            explode(',', $field),
            3,
            null
        );

        sscanf($field, '%[^.].%[^.]', $table, $field);

        $row = Database::connect($data['DBGroup'] ?? null)
            ->table($table)
            ->select('1')
            ->where($field, $str)
            ->limit(1);

        if (
            !empty($ignoreField) && !empty($ignoreValue)
            && !preg_match('/^\{(\w+)\}$/', $ignoreValue)
        ) {
            $row = $row->where("{$ignoreField} !=", $ignoreValue);
        }

        $field = strtoupper($field);
        $error = "O $field fornecido já está cadastrado no sistema";

        return $row->get()->getRow() === null;
    }
}
