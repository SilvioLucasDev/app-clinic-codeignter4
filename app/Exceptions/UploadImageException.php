<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use Exception;

class UploadImageException extends Exception implements ExceptionInterface
{
    public function __construct(?string $message = 'Erro ao fazer upload de imagem', ?int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
