<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Dtos\Patient\PatientStoreDTO;
use App\Dtos\Patient\PatientUpdateDTO;
use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Exceptions\ValidationException;
use App\Models\AddressModel;
use App\Models\PatientModel;
use App\Models\StateModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class PatientController extends BaseController
{
    public function __construct(
        protected PatientModel $patientModel = new PatientModel(),
        protected AddressModel $addressModel = new AddressModel(),
        protected StateModel $stateModel = new StateModel()
    ) {
    }

    public function index(): ResponseInterface
    {
        try {
            if ($search = $this->request->getVar('search')) {
                $this->patientModel->like('name', $search);
                $this->patientModel->orLike('cpf', $search);
                $this->patientModel->orLike('cns', $search);
            }

            if ($this->request->getVar('search_deleted')) $this->patientModel->onlyDeleted();

            $patients = $this->patientModel->select('id, name, cpf, cns')->orderBy('id')->paginate(10);
            $pagination = $this->patientModel->pager->getDetails();

            return $this->response->setJSON([
                'data' => [
                    'patients' => $patients,
                    'pagination' => $pagination,
                ]
            ])->setStatusCode(200);
        } catch (Exception $e) {
            return $this->response->setJSON(['data' => ['error' => 'Operation erro']])->setStatusCode(500);
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
            $patient = $this->patientModel->select('id')->find($id);
            if (!$patient) throw new PatientNotFoundException();

            $deleted = $this->patientModel->delete($patient->id);
            if (!$deleted) throw new OperationException();

            return $this->response->setStatusCode(204);
        } catch (Exception $e) {
            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }

    public function active(string $id): ResponseInterface
    {
        try {
            $patient = $this->patientModel->select('id')->onlyDeleted()->find($id);
            if (!$patient) throw new PatientNotFoundException();

            $activated = $this->patientModel->update($patient->id, ['deleted_at' => null]);
            if (!$activated) throw new OperationException();

            return $this->response->setStatusCode(204);
        } catch (Exception $e) {
            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }
}
