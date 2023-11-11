<?= $this->extend('partials/app') ?>

<?= $this->section('page_title') ?> Paciente <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-md-center">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Cadastrar Paciente
            </div>
            <div class="card-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-1">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="birth_date" class="form-label">Dt. Nascimento *</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date">
                        </div>

                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf">
                        </div>
                        <div class="col-md-6">
                            <label for="cns" class="form-label">CNS *</label>
                            <input type="text" class="form-control" id="cns" name="cns">
                        </div>

                        <div class="col-md-12">
                            <label for="image" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <div class="col-md-12">
                            <label for="mother_name" class="form-label">Nome da Mãe *</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name">
                        </div>

                        <div class="col-md-3">
                            <label for="zipcode" class="form-label">CEP *</label>
                            <input type="text" class="form-control" id="zipcode" name="zipcode">
                        </div>
                        <div class="col-md-4">
                            <label for="street" class="form-label">Rua *</label>
                            <input type="text" class="form-control" id="street" name="street">
                        </div>

                        <div class="col-md-5">
                            <label for="neighborhood" class="form-label">Bairro *</label>
                            <input type="text" class="form-control" id="neighborhood" name="neighborhood">
                        </div>

                        <div class="col-6">
                            <label for="number" class="form-label">Número *</label>
                            <input type="text" class="form-control" id="number" name="number">
                        </div>
                        <div class="col-6">
                            <label for="complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complement" name="complement">
                        </div>

                        <div class="col-6">
                            <label for="city" class="form-label">Cidade *</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="col-6">
                            <label for="state_id" class="form-label">Estado *</label>
                            <select class="form-select" id="state_id" name="state_id">
                                <option value="" selected>Selecione um Estado</option>
                                <?php foreach ($states as $state) : ?>
                                    <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <a class="btn btn-secondary" href="<?= url_to('patient.index') ?>">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>