<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Portada",
                ""
        ) ?>           
        <?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/TextReader.js"></script>
		<script src="/js/Modal.js"></script>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Comprabenta de productos de segunda mano') ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1>Bienvenido</h1>

			<section id="chollos">
				<h2>Gangas</h2>
				<p>¡Estas son nuestras gangas! <i><b>Cuidado,</b> ¡nos las quitan de las manos!</i></p>
				<div class="gallery w100 centered-block my2">
					<?php 
					foreach($chollos as $chollo)
					{ 
						file_exists(substr(AD_IMAGE_FOLDER, 1).'/'.$chollo->imagen) && !$chollo->imagen == NULL ? 
                        $imagen = AD_IMAGE_FOLDER.'/'.$chollo->imagen :
                        $imagen = AD_IMAGE_FOLDER.'/'.DEFAULT_AD_IMAGE;
						?>
					<div>
						<figure class="small card">
						<img class="square fit with-modal" src="<?=$imagen?>" alt="Imagen">
						<figcaption><?= $chollo->titulo.', de '.$chollo->autor ?>.</figcaption>
					</figure>
					<form method="GET" action="/Anuncio/show/<?= $chollo->id?>" class="no-border centered">
							<input type="submit" value="Ver" name="aceptar" class="button">
						</form>	
					</div>
					<?php }?>
				</div>
			</section>

    		<section id="galeria">
				<h2>Novedades</h2>
				<p>Estos son nuestras últimas adquisiciones</p>
				<div class="gallery w100 centered-block my2">
					<?php 
					foreach($anuncios as $anuncio)
					{ 
						file_exists(substr(AD_IMAGE_FOLDER, 1).'/'.$anuncio->imagen) && !$anuncio->imagen == NULL ? 
                        $imagen = AD_IMAGE_FOLDER.'/'.$anuncio->imagen :
                        $imagen = AD_IMAGE_FOLDER.'/'.DEFAULT_AD_IMAGE;
						?>
					<div>
						<figure class="small card">
						<img class="square fit with-modal" src="<?=$imagen?>" alt="Imagen">
						<figcaption><?= $anuncio->titulo.', de '.$anuncio->autor ?>.</figcaption>
					</figure>
					<form method="GET" action="/Anuncio/show/<?= $anuncio->id?>" class="no-border centered">
							<input type="submit" value="Ver" name="aceptar" class="button">
						</form>	
					</div>
					<?php }?>
				</div>
			</section>
		    
		               
            <section class="warning">
		    	<h2>IMPORTANTE</h2>
		    	<p>Se está elaborando la <a href="https://fastlight.org/Backend">documentación Backend</a> (esto me llevará un tiempo) y en
		    	breve también se comenzarán a publicar los manuales en PDF con ejemplos prácticos.
		    	Lo encontraréis todo en <a href="https://fastlight.org">la documentación oficial de FastLight</a>. 
		    	</p>
		    	<p>Estad también atentos a mi 
 				<a href='https://www.linkedin.com/in/robert-sallent-l%C3%B3pez-4187a866'>LinkedIn</a> personal.</p>
		    </section>
		    
		    
           <section class="flex1">
           		<h2>Requisitos</h2>
           		 
           		<p>Actualmente, <b>la versión <?= APP_VERSION ?> del framework</b> ha sido 
           		testeada en <b>PHP <?= MIN_PHP_VERSION ?></b> con <b>MySQL 8</b>.
           		Esto no quiere decir que no funcione en versiones ligeramente anteriores o posteriores,
           		pero no se garantiza que lo haga.</p>
           		<?= "Actualmente este servidor dispone de <b>PHP ".phpversion().".</b>" ?>
           </section>
		</main>

		<!-- este mapa web solamente se muestra en pantallas grandes -->
		<nav class="web-map">  
			<h2>Links</h2>
			
			<ul class="flex-container">   		
				<li class="flex1"><a href="#">Recursos</a>
					<ul>
						<li><a target="_blank" href="https://github.com/robertsallent/fastlight">GitHub</a></li>
						<li><a target="_blank" href="https://fastlight.org">Documentación oficial</a></li>
					</ul>
				</li>
				
				<li class="flex1"><a href="https://fastlight.org/Example#list">Documentación</a>
					<ul>
						<li><a target="_blank" href="https://fastlight.org/Example">Frontend</a></li>
						<li><a target="_blank" href="https://fastlight.org/Backend">Backend</a></li>
						<li><a target="_blank" href="#">Manuales PDF (TODO)</a></li>
					</ul>
				</li>
				
				<li class="flex1"><a href="#">Ejemplos de clase</a>
					<ul>
						<li><a target="_blank" href="https://larabikes.robertsallent.com">Larabikes (Laravel)</a></li>
						<li><a target="_blank" href="https://symfofilms.robertsallent.com">SymfoFilms (Symfony)</a></li>
						<li><a target="_blank" href="https://biblioteca.fastlight.org">Biblioteca (FastLight)</a></li>
					</ul>
				</li>
				
				<li class="flex1"><a href="#">Otros proyectos</a>
					<ul>
						<li><a target="_blank" href="https://juegayestudia.com">Juega y Estudia</a></li>
						<li><a target="_blank" href="https://veinspercubelles.org">Veïns per Cubelles</a></li>
					</ul>
				</li>
			</ul>
		</nav>
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

