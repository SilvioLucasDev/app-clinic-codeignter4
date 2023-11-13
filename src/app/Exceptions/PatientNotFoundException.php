<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use Exception;

class PatientNotFoundException extends Exception implements ExceptionInterface
{
    public function __construct(?string $message = 'Paciente não encontrado', ?int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
