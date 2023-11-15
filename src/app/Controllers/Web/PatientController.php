<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Dtos\Patient\PatientStoreDTO;
use App\Dtos\Patient\PatientUpdateDTO;
use App\Exceptions\PatientNotFoundException;
use App\Exceptions\ValidationException;
use App\Models\PatientModel;
use App\Models\StateModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Exception;

class PatientController extends BaseController
{
    public function __construct(
        protected PatientModel $patientModel = new PatientModel(),
        protected StateModel $stateModel = new StateModel()
    ) {
    }

    public function index(): string
    {
        try {
            $queryParams = $this->request->getUri()->getQuery();
            parse_str($queryParams, $params);
            $search = $params['search'] ?? null;
            $searchDeleted = $params['search_deleted'] ?? null;

            $action = Services::patientIndexAction();
            $list = $action->execute($search, $searchDeleted);

            return view('patient/index', [
                'patients' => $list->patients,
                'pagination' =>  $list->pagination,
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
            $data['image'] = $this->request->getFile('image');

            if ($data['image']) {
                if (!$data['image']->isValid()) $data['image'] = null;
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
            $action = Services::patientShowAction();
            $patient = $action->execute($id);

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
            $data['id'] = $id;
            $data['image'] = $this->request->getFile('image');

            if ($data['image']) {
                if (!$data['image']->isValid()) $data['image'] = null;
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
            $action = Services::patientDestroyAction();
            $action->execute($id);

            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente deletado com sucesso']);
        } catch (Exception $e) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => $e->getMessage()]);
        }
    }

    public function active(string $id): RedirectResponse
    {
        try {
            $action = Services::patientActiveAction();
            $action->execute($id);

            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'success', 'text' => 'Paciente ativado com sucesso']);
        } catch (Exception $e) {
            return redirect()->route('patient.index')->withInput()->with('message', ['type' => 'error', 'text' => $e->getMessage()]);
        }
    }
}
