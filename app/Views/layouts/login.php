<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title><?= env('app.site.title') ?> - <?= $this->data['title'] ?></title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<? // TODO implement error display ?>
<form class="form-signin" method="post" action="<?= base_url('login/submit') ?>">
    <img class="mb-4" src="/assets/images/logo.png" alt="" width="153" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Bitte logge dich ein</h1>
    <label for="mail" class="sr-only">E-Mail</label>
    <input type="email" id="mail" class="form-control" placeholder="E-Mail" autofocus>
    <label for="password" class="sr-only">Passwort</label>
    <input type="password" id="password" class="form-control" placeholder="Passwort" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Einloggen</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2019 by Adrastea Project - <a
                href="https://github.com/localhorstviersen/adrastea">GitHub</a></p>
</form>
</body>
</html>