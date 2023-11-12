<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\PatientModel;
use App\Models\StateModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Database;

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
        if ($search = $this->request->getVar('search')) {
            $this->patientModel->like('name', $search);
            $this->patientModel->orLike('cpf', $search);
            $this->patientModel->orLike('cns', $search);
        }

        if ($this->request->getVar('searchDeleted')) $this->patientModel->onlyDeleted();

        $patients = $this->patientModel->select('id, name, cpf, cns')->orderBy('id')->paginate(10);

        return view('patient/index', [
            'patients' => $patients,
            'pager' => $this->patientModel->pager,
        ]);
    }

    public function create(): string
    {
        return view('patient/create', [
            'states' => $this->stateModel->findAll()
        ]);
    }

    public function store(): RedirectResponse
    {
        if (!$this->validate('patient_store')) {
            return redirect()->route('patient.create')->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->validator->getValidated();

        $image = $this->request->getFile('image');
        if ($image->isValid()) {
            $path = upload_image($image, 'assets/images/patients');
            if (!$path) return handle_response('error', 'Erro ao cadastrar paciente', 'patient.create');
            $data['image'] = $path;
        }

        $db = Database::connect();
        $db->transStart();
        $this->patientModel->save($data);
        $data['patient_id'] = $this->patientModel->getInsertID();
        $this->addressModel->save($data);

        if (!$db->transComplete()) {
            remove_image($data['image']);
            return handle_response('error', 'Erro ao cadastrar paciente', 'patient.create');
        }

        return handle_response('success', 'Paciente cadastrado com sucesso', 'patient.index');
    }

    public function edit(string $id): string
    {
        $patient = $this->patientModel->select('
                patients.id, patients.image, patients.name, patients.mother_name, patients.birth_date, patients.cpf, patients.cns,
                addresses.zip_code, addresses.street, addresses.number, addresses.complement, addresses.neighborhood, addresses.city, addresses.state_id
            ')
            ->join('addresses', 'addresses.patient_id = patients.id')
            ->join('states', 'states.id = addresses.state_id')
            ->find($id);

        if (!$patient) return handle_response('error', 'Paciente não encontrado', 'patient.index');

        return view('patient/edit', [
            'patient' => $patient,
            'states' => $this->stateModel->findAll()
        ]);
    }

    public function update(string $id): RedirectResponse
    {
        if (!$this->validate('patient_update')) {
            return redirect()->route('patient.edit', [$id])->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->validator->getValidated();

        $patient = $this->patientModel->select('patients.id, patients.image, addresses.id AS address_id')
            ->join('addresses', 'addresses.patient_id = patients.id')
            ->find($id);

        if (!$patient) return handle_response('error', 'Paciente não encontrado', 'patient.index');

        $image = $this->request->getFile('image');
        if ($image->isValid()) {
            $path = upload_image($image, 'assets/images/patients');
            if (!$path) return handle_response('error', 'Erro ao atualizar os dados do paciente', 'patient.edit', [$id]);
            if (isset($patient->image)) remove_image($patient->image);
            $data['image'] = $path;
        }

        $db = Database::connect();
        $db->transStart();
        $this->patientModel->update($patient->id, $data);
        $this->addressModel->update($patient->address_id, $data);

        if (!$db->transComplete()) {
            remove_image($data['image']);
            return handle_response('error', 'Erro ao atualizar os dados do paciente', 'patient.edit', [$id]);
        }

        return handle_response('success', 'Dados do paciente atualizado com sucesso', 'patient.edit', [$id]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $patient = $this->patientModel->select('id')->find($id);

        if (!$patient) return handle_response('error', 'Paciente não encontrado', 'patient.index');

        $this->patientModel->delete($patient->id);

        return handle_response('success', 'Paciente deletado com sucesso', 'patient.index');
    }

    public function active(string $id): RedirectResponse
    {
        $patient = $this->patientModel->select('id')->withDeleted()->find($id);

        if (!$patient) return handle_response('error', 'Paciente não encontrado', 'patient.index');

        $this->patientModel->update($patient->id, ['deleted_at' => null]);

        return handle_response('success', 'Paciente ativado com sucesso', 'patient.index');
    }
}
