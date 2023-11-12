<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use Exception;

class ValidationException extends Exception implements ExceptionInterface
{
    protected array|string $data;

    public function __construct(array|string $data, ?int $code = 422, ?string $message = 'Erro de validação')
    {
        parent::__construct($message, $code);
        $this->data = $data;
    }

    public function getData(): array|string
    {
        return $this->data;
    }
}
