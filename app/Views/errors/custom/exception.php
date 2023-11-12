<?= $this->extend('partials/app') ?>

<?= $this->section('page_title') ?> Erro <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body text-center ">
        <h1>Erro no servidor</h1>
        <p>Se o erro persistir entre em contato com o suporte</p>
    </div>
</div>

<?= $this->endSection() ?>