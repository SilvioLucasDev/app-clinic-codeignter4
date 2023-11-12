<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use Exception;

class OperationException extends Exception implements ExceptionInterface
{
    public function __construct(?string $message = 'Erro na operação', ?int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
