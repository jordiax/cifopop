<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Lista de libros en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Detalle de libro - <?= APP_NAME ?></title>
    </head>
    <body>
        <script src="/js/modal.js"></script>
        <script src="/js/preview.js"></script>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Nuevo usuario') ?>
        <?= $template->breadCrumbs(['Panel del administrador'=>'/Panel/admin', 'Usuarios'=>'/User/list', "Nuevo"=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <section id="new-user">
                <div class="flex-container">
                    <form action="/User/store" method="post" enctype="multipart/form-data" class="form no-border flex2">
                        <label>Nombre:</label>
                        <input type="text" name="displayname" value="<?= old('displayname') ?>">
                        <br>
                        <label>Email:</label>
                        <input type="email" name="email" id="inputEmail" value="<?= old('email') ?>">
                        <br>
                        <label>Teléfono:</label>
                        <input type="text" name="phone" value="<?= old('phone') ?>">
                        <br>
                        <label>Password:</label>
                        <input type="password" name="password">
                        <br>
                        <label>Repetir:</label>
                        <input type="password" name="repeatpassword">
                        <br>
                        <label>Imagen:</label>
                        <input type="file" name="portada" id="file-with-preview" accept="image/*">
                        <br>
                        <?php if(Login::isAdmin()) { ?>
                            <label>Rol:</label>
                            <select name="roles" id="roles">
                            <?php foreach(USER_ROLES as $roleName => $roleValue){ ?>
                                <option value="<?=$roleValue?>"><?=$roleName?></option>
                            <?php } 
                        } ?>
                        </select>

                        <div class="centered mt3">
                            <input type="submit" value="Guardar" name="guardar" class="button">
                            <input type="reset" value="Reset" class="button">
                        </div>
                    </form>

                    <figure class="flex1 centrado">
                        <img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>" 
                            id="preview-image" class="cover enlarge-image" alt="Imagen de perfil de <?= $user->displayname ?>">
                        <figcaption>Imagen de perfil de <?= $user->displayname ?></figcaption>
                    </figure>
                </div>
            </section>
            <div class="centrado m1">
                <a class="button" onclick="history.back()">Atrás</a>
            </div>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>