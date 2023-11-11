<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\PatientModel;
use App\Models\StateModel;
use CodeIgniter\HTTP\RedirectResponse;

class PatientController extends BaseController
{
    public function index(): string
    {
        $patientModel = new PatientModel();
        if ($search = $this->request->getVar('search')) {
            $patientModel->like('name', $search);
            $patientModel->orLike('cpf', $search);
            $patientModel->orLike('cns', $search);
        }
        $patients = $patientModel->select('id, name, cpf, cns')->paginate(10);

        return view('patient/index', [
            'patients' => $patients,
            'pager' => $patientModel->pager,
        ]);
    }

    public function create(): string
    {
        helper('custom');

        $stateModel = new StateModel();
        $states = $stateModel->findAll();

        return view('patient/create', [
            'states' => $states
        ]);
    }

    public function store(): RedirectResponse
    {
        helper('custom');

        if (!$this->validate('patient_store')) {
            return redirect()->route('patient.create')->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->validator->getValidated();
        $image = $this->request->getFile('image');

        if ($image->isValid()) {
            if (!$image->move('assets/images/patients', $image->getRandomName())) {
                return redirect()->route('patient.create')->withInput()->with('message', ['type' => 'error', 'text' => 'Erro ao cadastrar paciente']);
            }
            $data['image'] = $image->getTempName() . $image->getName();
        }

        $patientModel = new PatientModel();
        $addressModel = new AddressModel();

        $patientData = [
            'image' => $data['image'] ?? null,
            'name' => $data['name'],
            'mother_name' => $data['mother_name'],
            'birth_date' => $data['birth_date'],
            'cpf' => sanitize_number($data['cpf']),
            'cns' => sanitize_number($data['cns']),
        ];

        $addressData = [
            'zipcode' => sanitize_number($data['zipcode']),
            'street' => $data['street'],
            'number' => $data['number'],
            'complement' => $data['complement'],
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state_id' => $data['state_id'],
        ];

        $patientModel->transStart();
        $patientModel->insert($patientData);
        $addressData['patient_id'] = $patientModel->getInsertID();
        $addressModel->insert($addressData);
        $patientModel->transComplete();

        if ($patientModel->transStatus() === false) {
            unlink($data['image']);
            return redirect()->route('patient.create')->withInput()->with('message', ['type' => 'error', 'text' => 'Erro ao cadastrar paciente']);
        }

        return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente cadastrado com sucesso']);
    }

    public function edit(string $id): string
    {
        helper('custom');

        $patientModel = new PatientModel();
        $patient = $patientModel->select('
                patients.id, patients.image, patients.name, patients.mother_name, patients.birth_date, patients.cpf, patients.cns,
                addresses.zipcode, addresses.street, addresses.number, addresses.complement, addresses.neighborhood, addresses.city, addresses.state_id
            ')
            ->join('addresses', 'addresses.patient_id = patients.id')
            ->join('states', 'states.id = addresses.state_id')
            ->find($id);

        if (!$patient) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => 'Paciente não encontrado']);
        }

        $stateModel = new StateModel();
        $states = $stateModel->findAll();

        return view('patient/edit', [
            'patient' => $patient,
            'states' => $states
        ]);
    }

    public function update(string $id): RedirectResponse
    {
        helper('custom');

        if (!$this->validate('patient_update')) {
            return redirect()->route('patient.edit', [$id])->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->validator->getValidated();
        $image = $this->request->getFile('image');

        $addressModel = new AddressModel();
        $patientModel = new PatientModel();
        $patient = $patientModel->select('patients.id, patients.image, addresses.id AS address_id')
            ->join('addresses', 'addresses.patient_id = patients.id')
            ->find($id);

        if (!$patient) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => 'Paciente não encontrado']);
        }

        if ($image->isValid()) {
            if (isset($patient->image)) {
                unlink($patient->image);
            }
            if (!$image->move('assets/images/patients', $image->getRandomName())) {
                return redirect()->route('patient.edit', [$id])->withInput()->with('message', ['type' => 'error', 'text' => 'Erro ao atualizar os dados do paciente']);
            }
            $data['image'] = $image->getTempName() . $image->getName();
        }

        $patientData = [
            'image' => $data['image'] ?? null,
            'name' => $data['name'],
            'mother_name' => $data['mother_name'],
            'birth_date' => $data['birth_date'],
            'cpf' => sanitize_number($data['cpf']),
            'cns' => sanitize_number($data['cns']),
        ];

        $addressData = [
            'zipcode' => sanitize_number($data['zipcode']),
            'street' => $data['street'],
            'number' => $data['number'],
            'complement' => $data['complement'],
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state_id' => $data['state_id'],
        ];

        $patientModel->transStart();
        $patientModel->update($patient->id, $patientData);
        $addressModel->update($patient->address_id, $addressData);
        $patientModel->transComplete();

        if ($patientModel->transStatus() === false) {
            if (isset($data['image'])) {
                unlink($data['image']);
            }
            return redirect()->route('patient.edit', [$id])->withInput()->with('message', ['type' => 'error', 'text' => 'Erro ao atualizar os dados do paciente']);
        }

        return redirect()->route('patient.edit', [$id])->withInput()->with('message', ['type' => 'success', 'text' => 'Dados do paciente atualizado com sucesso']);
    }

    public function destroy(string $id): RedirectResponse
    {
        $patientModel = new PatientModel();
        $patient = $patientModel->select('id')->find($id);

        if (!$patient) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => 'Paciente não encontrado']);
        }

        $patientModel->delete($patient->id);

        return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente deletado com sucesso']);
    }
}
