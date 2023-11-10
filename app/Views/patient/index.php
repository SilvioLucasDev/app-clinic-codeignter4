<?= $this->extend('partials/app') ?>

<?= $this->section('page_title') ?> Paciente <?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-md-center text-center">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between mb-3">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <form action="<?= url_to('patient.index') ?>" method="GET">
                            <?= csrf_field() ?>
                            <div class="input-group">
                                <input class="form-control" type="text" name="search" placeholder="Procurar Pacientes" value="<?= service('request')->getVar('search') ?? '' ?>">
                                <button class="btn btn-primary" type="submit">Procurar</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-6 text-md-end mb-3 mb-md-0 d-grid d-md-block">
                        <button class="btn btn-primary" type="submit">+ Cadastrar</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
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
                                    <td><?= $patient->cpf ?></td>
                                    <td><?= $patient->cns ?></td>
                                    <td>...</td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?= $pager->links('default', 'pagination_custom') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>