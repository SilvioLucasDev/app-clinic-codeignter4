<?= $this->extend('partials/app') ?>

<?= $this->section('page_title') ?> Paciente <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        Visualizar / Atualizar Cadastro do Paciente
    </div>
    <div class="card-body">
        <div class="row mb-4 text-center">
            <div class="col">
                <img src="<?= base_url($patient->image ?? 'assets/images/patients/default.png') ?>" alt="Foto do Paciente">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <form action="<?= url_to('patient.update', $patient->id) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="<?= $patient->id ?>">

                    <div class="row g-1">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?? $patient->name ?>">
                            <span class="text text-danger">
                                <?= display_error('name') ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="birth_date" class="form-label">Dt. Nascimento *</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?= old('birth_date') ?? $patient->birth_date ?>">
                            <span class="text text-danger">
                                <?= display_error('birth_date') ?>
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?= old('cpf') ?? $patient->cpf ?>">
                            <span class="text text-danger">
                                <?= display_error('cpf') ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="cns" class="form-label">CNS *</label>
                            <input type="text" class="form-control cns" id="cns" name="cns" value="<?= old('cns') ?? $patient->cns ?>">
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
                            <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?= old('mother_name') ?? $patient->mother_name ?>">
                            <span class="text text-danger">
                                <?= display_error('mother_name') ?>
                            </span>
                        </div>

                        <div class="col-md-3">
                            <label for="zip_code" class="form-label">CEP *</label>
                            <input type="text" class="form-control zip_code" id="zip_code" name="zip_code" value="<?= old('zip_code') ?? $patient->zip_code ?>" onblur="searchZipCode(this.value)">
                            <span class="text text-danger">
                                <?= display_error('zip_code') ?>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="street" class="form-label">Rua *</label>
                            <input type="text" class="form-control" id="street" name="street" value="<?= old('street') ?? $patient->street ?>">
                            <span class="text text-danger">
                                <?= display_error('street') ?>
                            </span>
                        </div>

                        <div class="col-md-5">
                            <label for="neighborhood" class="form-label">Bairro *</label>
                            <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="<?= old('neighborhood') ?? $patient->neighborhood ?>">
                            <span class="text text-danger">
                                <?= display_error('neighborhood') ?>
                            </span>
                        </div>

                        <div class="col-6">
                            <label for="number" class="form-label">Número *</label>
                            <input type="text" class="form-control" id="number" name="number" value="<?= old('number') ?? $patient->number ?>">
                            <span class="text text-danger">
                                <?= display_error('number') ?>
                            </span>
                        </div>
                        <div class="col-6">
                            <label for="complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complement" name="complement" value="<?= old('complement') ?? $patient->complement ?>">
                            <span class="text text-danger">
                                <?= display_error('complement') ?>
                            </span>
                        </div>

                        <div class="col-6">
                            <label for="city" class="form-label">Cidade *</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= old('city') ?? $patient->city ?>">
                            <span class="text text-danger">
                                <?= display_error('city') ?>
                            </span>
                        </div>
                        <div class="col-6">
                            <label for="state_id" class="form-label">Estado *</label>
                            <select class="form-select" id="state_id" name="state_id">
                                <option value="" selected>Selecione um Estado</option>
                                <?php foreach ($states as $state) : ?>
                                    <option value="<?= $state->id ?>" <?= (old('state_id') ?? $patient->state_id) === $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="text text-danger">
                                <?= display_error('state_id') ?>
                            </span>
                        </div>

                        <div class="col-12 mt-4">
                            <a class="btn btn-secondary" href="<?= url_to('patient.index') ?>">Cancelar</a>
                            <button type="submit" class="btn btn-danger">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('js') ?>
<script src="<?= base_url('assets/js/viaCep.js') ?>"></script>
<script src="<?= base_url('assets/js/mask.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>