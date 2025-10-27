<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Editar anuncio en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Edición del anuncio - <?= APP_NAME ?></title>
    </head>
    <body>
        <script src="/js/modal.js"></script>
        <script src="/js/preview.js"></script>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Edición de anuncio') ?>
        <?= $template->breadCrumbs(['Anuncios'=>'/Anuncio/list', "$anuncio->titulo"=>"/Anuncio/show/$anuncio->id", 'Editar'=>null]) ?>
        <?= $template->messages() ?>
        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Editar anuncio</h2>
            <section class="flex-container gap2">
                <form method="POST" class="form flex2 no-border" enctype="multipart/form-data" action="/Anuncio/update">
                    
                    <input type="hidden" name="id" value="<?= $anuncio->id ?>">
                    <input type="hidden" name="iduser" value="<?= $anuncio->iduser ?>">

                    <label>Título:</label>
                    <input type="text" name="titulo" value="<?= old('titulo', $anuncio->titulo) ?>">
                    <br>
                    <label>Pecio:</label>
                    <input type="text" name="precio" value="<?= old('precio', $anuncio->precio)?>">
                    <br>
                    <label>Portada:</label>
                    <input type="file" name="imagen" id="file-with-preview" accept="image/*">
                    <br>
                    <label>Descripción:</label>
                    <textarea name="descripcion" class="w50"><?= old('descripcion', $anuncio->descripcion) ?></textarea>
                    <div class="centrado mt2">
                        <input type="submit" value="Actualizar" name="actualizar" class="button">
                        <input type="reset" value="Reset" class="button">
                    </div>
                </form>
                <figure class="flex1 centrado">
                    <img src="<?= AD_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_AD_IMAGE) ?>" 
                        id="preview-image" class="cover with-modal" alt="Imagen del anuncio <?= $anuncio->titulo?>">
                        <figcaption>Imagen del anuncio <?= "$anuncio->titulo"?></figcaption>

                        <?php if($anuncio->imagen){?>
                        <form action="/Anuncio/dropimage" method="post" class="no-border">
                            <input type="hidden" name="id" value="<?= $anuncio->id ?>">
                            <input type="submit" value="Eliminar imagen" name="borrar" class="button-danger">
                        </form>
                        <?php } ?>
                </figure>
            </section>

            <div class="centrado m1">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Anuncio/list">Listado de anuncios</a>
                <a class="button" href="/Anuncio/show/<?=$anuncio->id?>">Detalles</a>
                <a class="button" href="/anuncio/delete/<?= $anuncio->id ?>">Eliminar</a>
            </div>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>