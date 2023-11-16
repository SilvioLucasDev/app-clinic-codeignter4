<?php

namespace App\Controllers\Api\Auth;

use App\Exceptions\ValidationException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use Exception;

class RegisterController extends ShieldRegister
{
    public function register(): ResponseInterface
    {
        try {
            $users = $this->getUserProvider();

            if (!$this->validate('auth_register')) throw new ValidationException($this->validator->getErrors());

            $data = $this->validator->getValidated();
            $user              = $this->getUserEntity();
            $user->fill($data);

            if ($user->username === null) {
                $user->username = null;
            }

            try {
                $users->save($user);
            } catch (ValidationException $e) {
                throw new ValidationException($users->errors());
            }

            $user = $users->findById($users->getInsertID());
            $users->addToDefaultGroup($user);
            $user->activate();

            return $this->response->setJSON(['data' => ['user_id' => $user->id]])->setStatusCode(201);
        } catch (Exception $e) {
            exit;
            if ($e instanceof ValidationException)  return $this->response->setJSON(['data' => ['error' => $e->getData()]])->setStatusCode($e->getCode());

            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }
}
