<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use Exception;

class InvalidCredentialsException extends Exception implements ExceptionInterface
{
    public function __construct(?string $message = 'Credenciais inválidas', ?int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
