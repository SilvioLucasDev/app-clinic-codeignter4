<?= $this->extend('partials/app') ?>

<?= $this->section('page_title') ?> Paciente <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        Listagem de Pacientes
    </div>
    <div class="card-body">
        <div class="row justify-content-between mb-3">
            <div class="col-12 col-md-6 mb-3 mb-md-0">
                <form action="<?= url_to('patient.index') ?>" method="GET">
                    <?= csrf_field() ?>
                    <div class="input-group">
                        <input class="form-control" type="text" name="search" placeholder="Procurar Pacientes" value="<?= service('request')->getVar('search') ?? '' ?>">
                        <button class="btn btn-danger" type="submit">Procurar</button>
                    </div>
                    <div class="form-check mt-1">
                        <input class="form-check-input" type="checkbox" id="search_deleted" name="search_deleted" value="1" <?= service('request')->getVar('search_deleted') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="search_deleted">Deletados</label>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6 text-md-end mb-3 mb-md-0 d-grid d-md-block">
                <a class="btn btn-danger" href="<?= url_to('patient.create') ?>">+ Cadastrar</a>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">CPF</th>
                                <th scope="col">CNS</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patients as $patient) : ?>
                                <tr>
                                    <th scope="row"><?= $patient->id ?></th>
                                    <td><?= $patient->name ?></td>
                                    <td class="cpf"><?= $patient->cpf ?></td>
                                    <td class="cns"><?= $patient->cns ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-link text-black " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?= url_to('patient.edit', $patient->id) ?>">Visualizar/Atualizar</a></li>

                                                <?php if (!$patient->deleted_at) : ?>
                                                    <li><button class="dropdown-item text-danger" onclick="openModalDelete('<?= url_to('patient.destroy', $patient->id) ?>')">Deletar</button></li>
                                                <?php else : ?>
                                                    <form action="<?= url_to('patient.active', $patient->id) ?>" method="POST">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="PATCH">
                                                        <li><button type="submit" class="dropdown-item text-success">Ativar</button></li>
                                                    </form>
                                                <?php endif ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?= $pagination->links('default', 'pagination_custom') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="deletarPacienteModal" tabindex="-1" aria-labelledby="deletarPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deletarPacienteModalLabel">Delatar Paciente</h1>
                <button id="deletarPacienteCloseButton" type="button" class="btn-close"></button>
            </div>

            <div class="modal-body">
                <div class="modal-body">
                    <h2 class="fs-5">Tem certeza que deseja deletar esse paciente?</h2>
                </div>
            </div>

            <div class="modal-footer">
                <button id="deletarPacienteCancelButton" type="button" class="btn btn-secondary">Cancelar</button>
                <form id="deletarPacienteForm" action="#" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Sim, eu tenho.</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Confirm Delete Modal -->

<?= $this->section('js') ?>
<script src="<?= base_url('assets/js/mask.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deletarPacienteModal = new bootstrap.Modal(document.getElementById('deletarPacienteModal'));

        function toggleModalDelete() {
            deletarPacienteModal.toggle();
        }

        window.openModalDelete = function(route) {
            document.getElementById('deletarPacienteForm').action = route;
            toggleModalDelete();
        }

        document.getElementById('deletarPacienteCloseButton').addEventListener('click', toggleModalDelete);
        document.getElementById('deletarPacienteCancelButton').addEventListener('click', toggleModalDelete);
    });
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>