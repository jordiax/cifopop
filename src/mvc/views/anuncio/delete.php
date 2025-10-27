<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Borrado de anuncio en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Borrado de anuncio - <?= APP_NAME ?></title>
    </head>
    <body>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Borrado de anuncio') ?>
        <?= $template->breadCrumbs(['Anuncios'=>'/Anuncio/list', "$anuncio->titulo"=>"/Anuncio/show/$anuncio->id", 'Borrar'=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Borrar anuncio <b><?= $anuncio->titulo ?></b></h2>

            <form action="/Anuncio/destroy/" class="p2 m2" method="post">
                <p>Confirmar el borrado del anuncio <b><?= $anuncio->titulo ?></b></p>

                <input type="hidden" name="id" value="<?= $anuncio->id ?>">
                <input type="submit" value="Borrar" name="borrar" class="button-danger">
            </form>

            <div class="centered">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Anuncio/list">Lista de anuncios</a>
                <a class="button" href="/Anuncio/show/<?= $anuncio->id ?>">Detalles</a>
                <a class="button" href="/Anuncio/edit/<?= $anuncio->id ?>">Edición</a>
            </div>
        </main>
    </body>
</html>