<?= $this->extend('partials/app') ?>

<?= $this->section('page_title') ?> Home <?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-md-center text-center">
    <div class="col-md-auto">
        <div class="card">
            <div class="card-body">
                <?php if (auth()->loggedIn()) : ?>
                    Olá, <?= auth()->user()->username ?>. Você está logado!

                    <a href="<?= url_to('logout') ?>">Sair</a>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>