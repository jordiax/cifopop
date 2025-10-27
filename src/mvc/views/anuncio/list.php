    <!DOCTYPE html>
    <html lang="<?= LANGUAGE_CODE ?>">
    	<head>
    		<?= $template->metaData(
                "Listado de anuncios",
                ""
            ) ?>           
            <?= $template->css() ?>
    	</head>
    	
    	<body>
    		<?= $template->login() ?>
			<?= $template->menu() ?>
    		<?= $template->header(null, 'Listado de los anuncios') ?>
    		<?= $template->breadCrumbs([
    		          "Listado de anuncios" => NULL  
    		      ]);
    		?>
    		<?= $template->messages() ?>
    		<?= $template->acceptCookies() ?>
    		
    		<main>
        		<h1><?= APP_NAME ?></h1>
        		
        		<?php 
                    // dump($anuncios);
        			// coloca el formulario para poner o quitar filtro
        			echo $template->filter(
            			// opciones para el desplegable "buscar en"
            			[
                			'Título' => 'titulo',
                			'Descripcion' => 'descripcion'
        			    ],
        			    
        			    // opciones para el desplegable "ordenar por"
        			    [
            			    'Título' => 'titulo',
                			'Descripcion' => 'descripcion',
                            'Precio' => 'precio'
            		    ],
            		    'Título', // opción seleccionada por defecto en "buscar en"
            		    'Título', // opción seleccionada por defecto en "ordenar por"
            		    $filtro  // filtro aplicado (null si no hay) - viene del controlador
        		    );
                if($anuncios){?>
                    <div class="right">
                <?= $paginator->stats() ?>
                </div>
                <div class="grid-list">
                <div class="grid-list-header">
                    <span class="span2">Imagen:</span>
                    <span class="span1">Título:</span>
                    <span class="span1">Precio:</span>
                    <span class="span3">Descripción:</span>
                    <span class="right">Operaciones</span>                    
                </div>
                <?php foreach ($anuncios as $anuncio){ 
                    dump(AD_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_AD_IMAGE));
                    ?>
                    
                    <div class="grid-list-item">
                        <a href="/Anuncio/show/<?= $anuncio->id ?>" class="span2">
                            <img src="<?= AD_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_AD_IMAGE) ?>" class="table-image" alt="Imagen de <?= $anuncio->titulo ?>">
                        </a>
                        <span class="span1"><a href="/Anuncio/show/<?= $anuncio->id ?>" data-label="titulo"><?= $anuncio->titulo ?></a></span>
                        <span data-label="precio" class="span1"><?= $anuncio->precio ?></span>
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
                <?= $paginator->ellipsisLinks() ?>
                <?php } 
                else{ ?>
                    <div class="danger p2">
                        <p>"No hay anuncios que mostrar.</p>
                    </div>
                <?php } ?>
            </main>
        </body>
    </html>