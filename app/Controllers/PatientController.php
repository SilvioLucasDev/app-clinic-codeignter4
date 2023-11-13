<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Dtos\Patient\PatientStoreDTO;
use App\Dtos\Patient\PatientUpdateDTO;
use App\Exceptions\OperationException;
use App\Exceptions\PatientNotFoundException;
use App\Exceptions\ValidationException;
use App\Models\AddressModel;
use App\Models\PatientModel;
use App\Models\StateModel;
use CodeIgniter\HTTP\RedirectResponse;
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

            $data = (object) $this->validator->getValidated();
            $data->image = $this->request->getFile('image');

            if ($data->image) {
                if (!$data->image->isValid()) $data->image = null;
            }

            $action = Services::patientStoreAction();
            $action->execute(PatientStoreDTO::make($data));

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

            $data = (object) $this->validator->getValidated();
            $data->id = $id;
            $data->image = $this->request->getFile('image');

            if ($data->image) {
                if (!$data->image->isValid()) $data->image = null;
            }

            $action = Services::patientUpdateAction();
            $action->execute(PatientUpdateDTO::make($data));

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
