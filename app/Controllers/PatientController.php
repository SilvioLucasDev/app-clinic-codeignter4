<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Exceptions\ValidationException;
use App\Models\AddressModel;
use App\Models\PatientModel;
use App\Models\StateModel;
use CodeIgniter\HTTP\RedirectResponse;
use Exception;

class PatientController extends BaseController
{
    public function __construct(
        protected PatientModel $patientModel = new PatientModel(),
        protected AddressModel $addressModel = new AddressModel(),
        protected StateModel $stateModel = new StateModel()
    ) {
    }

    public function index(): string
    {
        try {
            if ($search = $this->request->getVar('search')) {
                $this->patientModel->like('name', $search);
                $this->patientModel->orLike('cpf', $search);
                $this->patientModel->orLike('cns', $search);
            }

            if ($this->request->getVar('search_deleted')) $this->patientModel->onlyDeleted();

            $patients = $this->patientModel->select('id, name, cpf, cns, deleted_at')->orderBy('id')->paginate(10);
            $pagination = $this->patientModel->pager;

            return view('patient/index', [
                'patients' => $patients,
                'pagination' =>  $pagination,
            ]);
        } catch (Exception $e) {
            return view('errors/custom/exception');
        }
    }

    public function create(): string|RedirectResponse
    {
        try {
            $sates = $this->stateModel->findAll();

            return view('patient/create', [
                'states' => $sates
            ]);
        } catch (Exception $e) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => 'Erro no servidor. Se o erro persistir entre em contato com o suporte']);
        }
    }

    public function store(): RedirectResponse
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
                throw new OperationException('Erro ao cadastrar paciente');
            }

            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente cadastrado com sucesso']);
        } catch (Exception $e) {
            if ($e instanceof ValidationException) return redirect()->route('patient.create')->withInput()->with('errors', $e->getData());

            return redirect()->route('patient.create')->withInput()->with('message', ['type' => 'error', 'text' => $e->getMessage()]);
        }
    }

    public function edit(string $id): string|RedirectResponse
    {
        try {
            $patient = $this->patientModel->select('
                    patients.id, patients.image, patients.name, patients.mother_name, patients.birth_date, patients.cpf, patients.cns,
                    addresses.zip_code, addresses.street, addresses.number, addresses.complement, addresses.neighborhood, addresses.city, addresses.state_id
                ')
                ->join('addresses', 'addresses.patient_id = patients.id')
                ->join('states', 'states.id = addresses.state_id')
                ->find($id);

            if (!$patient) throw new PatientNotFoundException();

            $states = $this->stateModel->findAll();

            return view('patient/edit', [
                'patient' => $patient,
                'states' => $states
            ]);
        } catch (Exception $e) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => $e->getMessage()]);
        }
    }

    public function update(string $id): RedirectResponse
    {
        try {
            if (!$this->validate('patient_update')) throw new ValidationException($this->validator->getErrors());

            $data = $this->validator->getValidated();
            $image = $this->request->getFile('image');
            unset($data['id']);

            if (!$data && !$image) throw new OperationException('Não há dados para atualizar');

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
                throw new OperationException('Erro ao atualizar os dados do paciente');
            }

            return redirect()->route('patient.edit', [$id])->withInput()->with('message', ['type' => 'success', 'text' => 'Dados do paciente atualizado com sucesso']);
        } catch (Exception $e) {
            if ($e instanceof ValidationException) return redirect()->route('patient.edit', [$id])->withInput()->with('errors', $e->getData());

            return redirect()->route('patient.edit', [$id])->withInput()->with('message', ['type' => 'error', 'text' => $e->getMessage()]);
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $patient = $this->patientModel->select('id')->find($id);
            if (!$patient) throw new PatientNotFoundException();

            $deleted = $this->patientModel->delete($patient->id);
            if (!$deleted) throw new OperationException('Erro ao deletar o paciente');

            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente deletado com sucesso']);
        } catch (Exception $e) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => $e->getMessage()]);
        }
    }

    public function active(string $id): RedirectResponse
    {
        try {
            $patient = $this->patientModel->select('id')->onlyDeleted()->find($id);
            if (!$patient) throw new PatientNotFoundException();

            $activated = $this->patientModel->update($patient->id, ['deleted_at' => null]);
            if (!$activated) throw new OperationException('Erro ao ativar o paciente');

            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente ativado com sucesso']);
        } catch (Exception $e) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => $e->getMessage()]);
        }
    }
}
