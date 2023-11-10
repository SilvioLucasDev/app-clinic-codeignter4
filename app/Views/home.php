<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Shield</title>
</head>

<body>
    <?php if (auth()->loggedIn()) : ?>
        Olá, <?= auth()->user()->username ?>. Você está logado!

        <a href="<?= url_to('logout') ?>">Logout</a>
    <?php else : ?>
        Você não está logado!
    <?php endif ?>
</body>

</html>