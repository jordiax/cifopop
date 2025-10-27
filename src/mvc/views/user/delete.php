<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Eliminación del uausario en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Eliminación del usuario - <?= $user->displayname ?></title>
    </head>
    <body>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Eliminación de usuario') ?>
        <?= $template->breadCrumbs(['Panel del administrador'=>'/Panel/admin', 'Usuarios'=>'/User/list', "$user->displayname"=>'/User/show/$user->id', 'Eliminar'=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Borrar usuario <b><?= $user->displayname ?></b></h2>

            <form action="/user/destroy/" class="p2 m2" method="post">
                <p>Confirmar el borrado del usuario <b><?= $user->displayname ?></b></p>

                <input type="hidden" name="id" value="<?= $user->id ?>">
                <input type="submit" value="Borrar" name="borrar" class="button-danger">
            </form>
            <div class="centrado m1">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/User/list">Listado de usuarios</a>
                <a class="button" href="/User/show/<?=$user->id?>">Detalles</a>                
                <a class="button" href="/User/edit/<?= $user->id ?>">Modificar</a>
            </div>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>