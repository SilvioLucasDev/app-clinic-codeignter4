<?= $this->extend('partials/app') ?>

<?= $this->section('page_title') ?> Paciente <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-md-center">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Atualizar Cadastro do Paciente
            </div>
            <div class="card-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-1">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $patient->name ?? old('name') ?>">
                            <span class="text text-danger">
                                <?= display_error('name') ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="birth_date" class="form-label">Dt. Nascimento *</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?= $patient->birth_date ?? old('birth_date') ?>">
                            <span class="text text-danger">
                                <?= display_error('birth_date') ?>
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $patient->cpf ?? old('cpf') ?>">
                            <span class="text text-danger">
                                <?= display_error('cpf') ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="cns" class="form-label">CNS *</label>
                            <input type="text" class="form-control" id="cns" name="cns" value="<?= $patient->cns ?? old('cns') ?>">
                            <span class="text text-danger">
                                <?= display_error('cns') ?>
                            </span>
                        </div>

                        <div class="col-md-12">
                            <label for="image" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="image" name="image" value="<?= old('image') ?>">
                            <span class="text text-danger">
                                <?= display_error('image') ?>
                            </span>
                        </div>

                        <div class="col-md-12">
                            <label for="mother_name" class="form-label">Nome da Mãe *</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?= $patient->mother_name ?? old('mother_name') ?>">
                            <span class="text text-danger">
                                <?= display_error('mother_name') ?>
                            </span>
                        </div>

                        <div class="col-md-3">
                            <label for="zipcode" class="form-label">CEP *</label>
                            <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?= $patient->zipcode ?? old('zipcode') ?>">
                            <span class="text text-danger">
                                <?= display_error('zipcode') ?>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="street" class="form-label">Rua *</label>
                            <input type="text" class="form-control" id="street" name="street" value="<?= $patient->street ?? old('street') ?>">
                            <span class="text text-danger">
                                <?= display_error('street') ?>
                            </span>
                        </div>

                        <div class="col-md-5">
                            <label for="neighborhood" class="form-label">Bairro *</label>
                            <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="<?= $patient->neighborhood ?? old('neighborhood') ?>">
                            <span class="text text-danger">
                                <?= display_error('neighborhood') ?>
                            </span>
                        </div>

                        <div class="col-6">
                            <label for="number" class="form-label">Número *</label>
                            <input type="text" class="form-control" id="number" name="number" value="<?= $patient->number ?? old('number') ?>">
                            <span class="text text-danger">
                                <?= display_error('number') ?>
                            </span>
                        </div>
                        <div class="col-6">
                            <label for="complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complement" name="complement" value="<?= $patient->complement ?? old('complement') ?>">
                            <span class="text text-danger">
                                <?= display_error('complement') ?>
                            </span>
                        </div>

                        <div class="col-6">
                            <label for="city" class="form-label">Cidade *</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= $patient->city ?? old('city') ?>">
                            <span class="text text-danger">
                                <?= display_error('city') ?>
                            </span>
                        </div>
                        <div class="col-6">
                            <label for="state_id" class="form-label">Estado *</label>
                            <select class="form-select" id="state_id" name="state_id">
                                <option value="" selected>Selecione um Estado</option>
                                <?php foreach ($states as $state) : ?>
                                    <option value="<?= $state->id ?>" <?= ($patient->state_id ?? old('state_id')) === $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="text text-danger">
                                <?= display_error('state_id') ?>
                            </span>
                        </div>

                        <div class="col-12 mt-4">
                            <a class="btn btn-secondary" href="<?= url_to('patient.index') ?>">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>