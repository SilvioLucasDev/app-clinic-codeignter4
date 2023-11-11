<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('page_title') ?? 'OM30' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/df04815b4a.js" crossorigin="anonymous"></script>
</head>

<body>
    <?= $this->renderSection('css') ?>

    <?= $this->include('partials/navbar') ?>

    <main class="container py-4">
        <?php if (isset(session()->get('message')['text'])) : ?>
            <div class="alert <?= session()->get('message')['type'] === 'error' ? 'alert-danger' : 'alert-success' ?>" role="alert">
                <?= session()->get('message')['text'] ?? '' ?>
            </div>
        <?php endif ?>

        <?= $this->renderSection('content') ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <?= $this->renderSection('js') ?>
</body>

</html>