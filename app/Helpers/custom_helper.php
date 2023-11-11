<?php

if (!function_exists('display_error')) {
    function display_error(string $field): string
    {
        return session()->get('errors')[$field] ?? '';
    }
}

if (!function_exists('sanitize_number')) {
    function sanitize_number(string $number): string
    {
        return preg_replace("/[^0-9]/", "", $number);
    }
}
