<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\ValidationException;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class AuthController extends BaseController
{
    public function login(): ResponseInterface
    {
        try {
            if (!$this->validate('auth_login')) throw new ValidationException($this->validator->getErrors());

            $data = $this->validator->getValidated();

            if (auth()->loggedIn()) {
                auth()->revokeAllAccessTokens();
                auth()->logout();
            }

            $result = auth()->attempt([
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            if (!$result->isOK()) throw new InvalidCredentialsException();

            $accessToken = auth()->user()->generateAccessToken($data['device_name']);

            return $this->response->setJSON(['data' => ['access_token' => $accessToken->raw_token]])->setStatusCode(200);
        } catch (Exception $e) {
            if ($e instanceof ValidationException)  return $this->response->setJSON(['data' => ['error' => $e->getData()]])->setStatusCode($e->getCode());

            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }
}
