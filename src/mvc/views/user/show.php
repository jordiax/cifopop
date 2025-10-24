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
            <h2>Usuario</h2>
            <section class="flex-container gap2">
                <div class="flex2">
                    <h2>Detalles del usuario "<?=$user->displayname?>"</h2>

                    <p><b>Nombre</b>                <?=$user->displayname?></p>
                    <p><b>Email</b>                 <?=$user->email?></p>
                    <p><b>Teléfono</b>              <?=$user->phone?></p>
                    <p><b>Alta</b>                  <?=$user->created_at?></p>
                    <p><b>Última actualización</b>  <?=$user->updated_at?></p>
                    <br>
                    <p><b>Roles</b> <?= arrayToString($user->roles) ?></p>
                </div>
                
                <figure class="flex1 centrado">
                    <img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>" 
                        id="preview-image" class="cover with-modal" alt="Imagen de perfil de <?= "$user->displayname"?>">
                        <figcaption>Imagen de perfil de <?= "$user->displayname"?></figcaption>
                </figure>
            </section>

            <div class="centrado m1">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/User/list">Listado de usuarios</a>
                <a class="button" href="/User/edit/<?=$user->id?>">Modificar</a>
                <?php if(Login::isAdmin()){ ?>
                <a class="button" href="/User/delete/<?= $user->id ?>">Eliminar</a>
                <?php }?>
            </div>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>