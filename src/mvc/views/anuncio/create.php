<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Nuevo anuncios en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Detalle de anuncio - <?= APP_NAME ?></title>
    </head>
    <body>
        <?= $template->login() ?>        
        <?= $template->menu() ?>
        <?= $template->header('Alta de anuncio') ?>
        <?= $template->breadCrumbs(["'".user()->displayname."'"=>'/User/home', 'Nuevo anuncio'=>null]) ?>
        <?= $template->messages() ?>
        <script src="/js/preview.js"></script>
        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Nuevo anuncio</h2>

            <form method="POST" enctype="multipart/form-data" action="/Anuncio/store" class="form flex-container gap2">
                <div class="flex2">
                    <input type="hidden" name="iduser" value="<?= user()->id ?>">
                    <label>Título:</label>
                    <input type="text" name="titulo" maxlength="255" value="<?= old('titulo') ?>" required>
                    <br>
                    <label>Precio:</label>
                    <input type="text" name="precio" maxlength="255" value="<?= old('precio')?>" required>
                    <br>                    
                    <label>Imagen:</label>
                    <input type="file" name="imagen" accept="image/*" id="file-with-preview">
                    <br>
                    <label>Descripción:</label>
                    <textarea name="descripcion" class="w50"><?= old('descripcion') ?></textarea>
                    <div>
                        <input type="submit" value="Guardar" name="guardar" class="button">
                        <input type="reset" value="Reset" class="button">
                    </div>
                </div>
                <figure class="flex1 centrado">
                    <img src="<?= AD_IMAGE_FOLDER.'/'.($anuncio->portada ?? DEFAULT_AD_IMAGE) ?>" 
                        id="preview-image" class="cover" alt="Previsualización de la portada">
                        <figcaption>Previsualización de la portada</figcaption>
                </figure>
            </form>
            <div>
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Anuncio/list">Listado de anuncios</a>
            </div>
        </main>
    </body>
</html>