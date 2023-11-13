<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Exceptions\ValidationException;
use App\Models\AddressModel;
use App\Models\PatientModel;
use App\Models\StateModel;
use CodeIgniter\HTTP\ResponseInterface;
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

            $data = $this->validator->getValidated();
            $image = $this->request->getFile('image');

            if ($image) {
                $path = upload_image($image, 'assets/images/patients');
                $data['image'] = $path;
            }

            $db = db_connect();
            $db->transStart();
            $this->patientModel->save($data);
            $data['patient_id'] = $this->patientModel->getInsertID();
            $this->addressModel->save($data);

            if (!$db->transComplete()) {
                if (isset($data['image'])) remove_image($data['image']);
                throw new OperationException();
            }

            return $this->response->setStatusCode(204);
        } catch (Exception $e) {
            if ($e instanceof ValidationException)  return $this->response->setJSON(['data' => ['error' => $e->getData()]])->setStatusCode($e->getCode());

            return $this->response->setJSON(['data' => ['error' => $e->getMessage()]])->setStatusCode($e->getCode());
        }
    }

    public function update(string $id): ResponseInterface
    {
        try {
            if (!$this->validate('patient_update')) throw new ValidationException($this->validator->getErrors());

            $data = $this->validator->getValidated();
            $image = $this->request->getFile('image');
            unset($data['id']);

            if (!$data && !$image) throw new ValidationException('Não há dados para atualizar', 422);

            $patient = $this->patientModel->select('patients.id, patients.image, addresses.id AS address_id')
                ->join('addresses', 'addresses.patient_id = patients.id')
                ->find($id);

            if (!$patient) throw new PatientNotFoundException();

            if ($image) {
                $path = upload_image($image, 'assets/images/patients');
                if (isset($patient->image)) remove_image($patient->image);
                $data['image'] = $path;
            }

            if (isset($data['image'])) $data['patient']['image'] = $data['image'];
            if (isset($data['name']))  $data['patient']['name'] = $data['name'];
            if (isset($data['mother_name'])) $data['patient']['mother_name'] = $data['mother_name'];
            if (isset($data['birth_date']))  $data['patient']['birth_date'] = $data['birth_date'];
            if (isset($data['cpf'])) $data['patient']['cpf'] = $data['cpf'];
            if (isset($data['cns'])) $data['patient']['cns'] =  $data['cns'];

            if (isset($data['zip_code'])) $data['address']['zip_code'] = $data['zip_code'];
            if (isset($data['street'])) $data['address']['street'] = $data['street'];
            if (isset($data['number'])) $data['address']['number'] = $data['number'];
            if (isset($data['neighborhood'])) $data['address']['neighborhood'] = $data['neighborhood'];
            if (isset($data['city'])) $data['address']['city'] = $data['city'];
            if (isset($data['state_id'])) $data['address']['state_id'] = $data['state_id'];

            $db = db_connect();
            $db->transStart();
            if (isset($data['patient'])) $this->patientModel->update($patient->id, $data['patient']);
            if (isset($data['address'])) $this->addressModel->update($patient->address_id, $data['address']);

            if (!$db->transComplete()) {
                if (isset($data['image'])) remove_image($data['image']);
                throw new OperationException();
            }

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
