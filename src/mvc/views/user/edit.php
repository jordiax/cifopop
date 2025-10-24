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
        <?= $template->breadCrumbs(['Panel del administrador'=>'/Panel/admin', 'Usuarios'=>'/User/list', "$user->displayname"=>"/User/show/$user->id", 'Editar'=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Editar usuario</h2>
            <section class="flex-container gap2">
                <form method="POST" class="form flex2 no-border" enctype="multipart/form-data" action="/User/update">
                    
                    <input type="hidden" name="id" value="<?= $user->id ?>">

                    <label>Nombre:</label>
                    <input type="text" name="displayname" value="<?= old('isbn', $user->displayname) ?>">
                    <br>
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= old('email', $user->email) ?>">
                    <br>
                    <label>Teléfono:</label>
                    <input type="text" name="phone" value="<?= old('phone', $user->phone)?>">
                    <br>
                    <label>Imagen:</label>
                    <input type="file" name="portada" id="file-with-preview" accept="image/*">
                    <br>
                    <div class="centrado mt2">
                        <input type="submit" value="Actualizar" name="actualizar" class="button">
                        <input type="reset" value="Reset" class="button">
                    </div>
                </form>
                <figure class="flex1 centrado">
                    <img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>" 
                        id="preview-image" class="cover with-modal" alt="Imagen de perfil de <?= "$user->displayname"?>">
                        <figcaption>Imagen de perfil de <?= "$user->displayname"?></figcaption>
                    <?php 
                    // TODO: Botón eliminar imagen en User.
                        /*if($user->picture){?>
                        <form action="/User/droppicture" method="post" class="no-border">
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <input type="submit" value="Eliminar imagen" name="borrar" class="button-danger">
                        </form>
                        <?php }*/ 
                    ?>
                </figure>
            </section>
            <section id="roles">
                <div class="grid-list">
                    <div class="grid-list-header">
                        <span class="span1">Nombre:</span> 
                        <span class="span1">Rol:</span>
                        <span class="right">Operaciones</span>
                    </div>
                    <?php foreach ($user->roles as $rolName=>$rol){ ?>
                        <div class="grid-list-item">
                            <span data-label="rolname" class="span1"><?= $rolName ?></span>
                            <span data-label="rol" class="span1"><?= $rol ?></span>
                            <form class="no-border" method="POST" action="/User/removerol">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <input type="hidden" name="rol" value="<?= $rol ?>">
                                <input type="submit" class="button-danger" name="remove" value="Eliminar">
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <form class="w50 m0 no-border" action="/User/addrol" method="post">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <select name="rol">
                        <?php
                        foreach(USER_ROLES as $rolName=>$rol)
                            echo "<option value='$rol'>$rolName</option>\n";
                        ?>
                    </select>
                    <input type="submit" class="button-success" name="add" value="Añadir rol">
                </form>
            </section>
            <div class="centrado m1">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/User/list">Listado de usuarios</a>
                <a class="button" href="/User/show/<?=$user->id?>">Detalles</a>
                <?php if(Login::isAdmin()){ ?>
                <a class="button" href="/User/delete/<?= $user->id ?>">Eliminar</a>
                <?php }?>
            </div>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>