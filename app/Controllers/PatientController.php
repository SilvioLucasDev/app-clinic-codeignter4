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
        $patient = new PatientModel();
        if ($search = $this->request->getVar('search')) {
            $patient->like('name', $search);
            $patient->orLike('cpf', $search);
            $patient->orLike('cns', $search);
        }
        $patients = $patient->select('id, name, cpf, cns')->paginate(10);

        return view('patient/index', [
            'patients' => $patients,
            'pager' => $patient->pager,
        ]);
    }

    public function create(): string
    {
        helper('custom');

        $state = new StateModel();
        $states = $state->findAll();

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
                return redirect()->route('patient.create')->withInput()->with('message', ['type' => 'error', 'text' => 'Erro ao salvar a imagem ']);
            }
        }

        $data['image'] = $image->getTempName() . $image->getName();

        $patientModel = new PatientModel();
        $addressModel = new AddressModel();

        $patientData = [
            'image' => $data['image'],
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

        return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente criado com sucesso']);
    }
}
