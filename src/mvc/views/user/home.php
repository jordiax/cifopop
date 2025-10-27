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
        <?= $template->header('CIFOpop', 'Página principal de  '.$user->displayname) ?>
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
            <section>
                <div class="grid-list">
                    <div class="grid-list-header">
                        <span class="span1">Imagen:</span>
                        <span class="span1">Título:</span>
                        <span class="span1">Precio:</span>
                        <span class="span3">Descripción:</span>
                        <span class="right">Operaciones</span>                    
                    </div>
                    <?php foreach ($anuncios as $anuncio){ 
                        // dump(AD_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_AD_IMAGE));             
                        file_exists(substr(AD_IMAGE_FOLDER, 1).'/'.$anuncio->imagen) && !$anuncio->imagen==NULL ? 
                            $imagen = AD_IMAGE_FOLDER.'/'.$anuncio->imagen :
                            $imagen = AD_IMAGE_FOLDER.'/'.DEFAULT_AD_IMAGE;
                    ?>                    
                    <div class="grid-list-item">
                        <a href="/Anuncio/show/<?= $anuncio->id ?>" class="span1">
                            <img src="<?= $imagen ?>" class="table-image" alt="Imagen de <?= $anuncio->titulo ?>">
                        </a>
                        <span class="span1"><a href="/Anuncio/show/<?= $anuncio->id ?>" data-label="titulo"><?= $anuncio->titulo ?></a></span>
                        <span data-label="precio" class="span1"><?= $anuncio->precio.'€' ?></span>
                        <span data-label="descripcion" class="span3"><?= $anuncio->descripcion ?></span>
                        <div class="right">
                            
                        <a href="/Anuncio/show/<?= $anuncio->id ?>">Ver</a>
                        <?php if(user() && intval($anuncio->iduser) == intval(user()->id)){ ?>
                            <a href="/Anuncio/edit/<?= $anuncio->id ?>">Editar</a>
                            <a href="/Anuncio/delete/<?= $anuncio->id ?>">Eliminar</a>
                        <?php } ?>
                        </div>
                    </div>
                    
                <?php } ?>
                </div>
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