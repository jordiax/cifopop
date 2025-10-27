<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Lista de anuncios en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    
        
        <title>Detalle de anuncio - <?= APP_NAME ?></title>
    </head>
    <body>
        <script src="/js/modal.js"></script>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Detalles de anuncio') ?>
        <?= $template->breadCrumbs(['Anuncios'=>'/Anuncio/list', 'Detalle'=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <h1><?= APP_NAME ?></h1>
            <section id="detalles" class="flex-container gap2">
                <div class="flex2">
                    <h2>Detalles del anuncio "<?=$anuncio->titulo?>"</h2>

                    <p><b>Título</b>          <?=$anuncio->titulo?></p>
                    <p><b>Precio</b>          <?=$anuncio->precio.'€'?></p>
                    <div>
                        <h3>Descripción:</h3>
                        <p><?= $anuncio->descripcion ? paragraph($anuncio->descripcion) : 'SIN DETALLES' ?></p>
                    </div>
                </div>
                <?php 
                    file_exists(substr(AD_IMAGE_FOLDER, 1).'/'.$anuncio->imagen) && !$anuncio->imagen == NULL ? 
                        $imagen = AD_IMAGE_FOLDER.'/'.$anuncio->imagen :
                        $imagen = AD_IMAGE_FOLDER.'/'.DEFAULT_AD_IMAGE;
                ?>
                <figure class="flex1 centrado p2">
                    <img src="<?= $imagen ?>" 
                        class="cover with-modal" alt="Imagen del anuncio <?= $anuncio->titulo?>">
                        <figcaption>Imagen del anuncio <?= "$anuncio->titulo"?></figcaption>
                </figure>
            </section>            
            
            <div class="centrado">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Anuncio/list">Lista de anuncios</a>
                <?php if(user() && intval($anuncio->iduser) == intval(user()->id)){ ?>
                    <a class="button" href="/Anuncio/edit/<?= $anuncio->id ?>">Editar</a>
                    <a class="button" href="/Anuncio/delete/<?= $anuncio->id ?>">Eliminar</a>
                <?php } ?>
            </div>
            <br>
        </main>
        <?= $template->footer() ?>
    </body>
</html>