<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Edición del uausario en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Edición del usuario - <?= $user->displayname ?></title>
    </head>
    <body>
        <script src="/js/modal.js"></script>
        <script src="/js/preview.js"></script>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Edición de usuario') ?>
        <?= $template->breadCrumbs(['Panel del administrador'=>'/Panel/admin', 'Usuarios'=>'/User/list', "$user->displayname"=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <h1><?= APP_NAME ?></h1>
            <form action="/User/newPassword" method="post">
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <label>Contraseña:</label>
                <input type="password" name="oldPassword">
                <br>
                <label>Nueva contraseña:</label>
                <input type="password" name="newPassword">
                <br>
                <label>Repetir contraseña:</label>
                <input type="password" name="repeatPassword">
                <br>
                <div class="centered">
                    <input type="submit" value="Guardar cambio" name="cambiar" class="button">
                </div>
            </form>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>