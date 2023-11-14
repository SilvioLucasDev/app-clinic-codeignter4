<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Dtos\Patient\PatientStoreDTO;
use App\Dtos\Patient\PatientUpdateDTO;
use App\Exceptions\ValidationException;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class PatientController extends BaseController
{
    public function index(): ResponseInterface
    {
        try {
            $queryParams = $this->request->getUri()->getQuery();
            parse_str($queryParams, $params);
            $search = $params['search'] ?? null;
            $searchDeleted = $params['search_deleted'] ?? null;

            $action = Services::patientIndexAction();
            $list = $action->execute($search, $searchDeleted);

            return $this->response->setJSON([
                'data' => [
                    'patients' => $list->patients,
                    'pagination' =>  $list->pagination->getDetails(),
                ]
            ])->setStatusCode(200);
        } catch (Exception $e) {
            return $this->response->setJSON(['data' => ['error' => 'Erro na operação']])->setStatusCode(500);
        }
    }

    public function store(): ResponseInterface
    {
        try {
            if (!$this->validate('patient_store')) throw new ValidationException($this->validator->getErrors());

            $data = (object) $this->validator->getValidated();
            $data->image = $this->request->getFile('image');

            if ($data->image) {
                if (!$data->image->isValid()) $data->image = null;
            }

            $action = Services::patientStoreAction();
            $action->execute(PatientStoreDTO::make($data));

            return $this->response->setStatusCode(201);
        } catch (Exception $e) {
            if ($e instanceof ValidationException)  return $this->response->setJSON(['data' => ['error' => $e->getData()]])->setStatusCode($e->getCode());

            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }

    public function update(string $id): ResponseInterface
    {
        try {
            if (!$this->validate('patient_update')) throw new ValidationException($this->validator->getErrors());

            $data = (object) $this->validator->getValidated();
            $data->id = $id;
            $data->image = $this->request->getFile('image');

            if ($data->image) {
                if (!$data->image->isValid()) $data->image = null;
            }

            $action = Services::patientUpdateAction();
            $action->execute(PatientUpdateDTO::make($data));

            return $this->response->setStatusCode(204);
        } catch (Exception $e) {
            if ($e instanceof ValidationException) return $this->response->setJSON(['data' => ['error' => $e->getData()]])->setStatusCode($e->getCode());

            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }

    public function destroy(string $id): ResponseInterface
    {
        try {
            $action = Services::patientDestroyAction();
            $action->execute($id);

            return $this->response->setStatusCode(204);
        } catch (Exception $e) {
            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }

    public function active(string $id): ResponseInterface
    {
        try {
            $action = Services::patientActiveAction();
            $action->execute($id);

            return $this->response->setStatusCode(204);
        } catch (Exception $e) {
            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }
}
