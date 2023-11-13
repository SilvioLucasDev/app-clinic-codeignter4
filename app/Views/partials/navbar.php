<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= url_to('home.index') ?>"><img src="<?= base_url('assets/images/site/logo.png') ?>" height="40" alt="Logo 0M30"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" aria-current="page" href="<?= url_to('home.index') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(uri_string(), 'patient') ? 'active' : '' ?>" href="<?= url_to('patient.index') ?>">Paciente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url_to('logout') ?>">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>