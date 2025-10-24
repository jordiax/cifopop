<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Home de <?=$user->displayname?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Home de <?=$user->displayname?></title>
    </head>
    <body>
        <script src="/js/modal.js"></script>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Edición de libro') ?>
        <?= $template->breadCrumbs(["$user->displayname"=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <section id="user-data" class="flex-container">
                <div class="flex2">
                    <h2><?= "Home de $user->displayname" ?></h2>

                    <p><b>Nombre:</b>               <?= $user->displayname ?></p>
                    <p><b>Email:</b>                <?= $user->email ?></p>
                    <p><b>Teléfono:</b>             <?= $user->phone ?></p>
                    <p><b>Fecha de alta:</b>        <?= $user->created_at ?></p>
                    <p><b>Última modificación:</b>  <?= $user->updated_at ?></p>
                    <?php if(Login::isAdmin()) { ?>
                    <p><b>Roles:</b> <?= arrayToString($user->roles) ?></p>
                    <?php } ?>
                </div>
                <figure class="flex1 centrado">
                    <img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>" 
                        class="cover enlarge-image" alt="Imagen de perfil de <?= $user->displayname ?>">
                    <figcaption>Imagen de perfil de <?= $user->displayname ?></figcaption>
                </figure>
            </section>
            <div class="left">
                <form action="/User/ChangePassword" method="post">
                    <input type="hidden" name="id" value="<?=$user->id?>">
                    <input type="submit" value="Cambiar Password" name="cambioPassword" class="button">
                </form>
            </div>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>