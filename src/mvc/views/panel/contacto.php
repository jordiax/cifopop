<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<meta charset="UTF-8">
		<title>Panel del bibliotecario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Formulario de contacto en <?= APP_NAME ?>">		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">			
		<!-- CSS -->
		<?= $template->css() ?>
        <link rel='stylesheet' media='screen' type='text/css' href='/css/bibliotecario.css'>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Formulario de contacto') ?>
		<?= $template->breadCrumbs(["Contacto" => null]) ?>
		<?= $template->messages() ?>
		
		<main>
            <div class="flex-container gap2">
                <section class="flex1" id="contacto">
                    <h2>Contacto</h2>
                    <p>Utiliza el formulario de contacto para enviar un mensaje al administrador de <?= APP_NAME ?></p>
                    <form action="/Contacto/send" method="post">
                        <label>Email</label>
                        <input type="email" name="email" required value="<?= old('email') ?>">
                        <br>
                        <label>Nombre</label>
                        <input type="text" name="nombre" required value="<?= old('nombre') ?>">
                        <br>
                        <label>Asunto</label>
                        <input type="text" name="asunto" required value="<?= old('asunto') ?>">
                        <br>
                        <label>Email</label>
                        <textarea name="mensaje" rquired><?= old('mensaje') ?></textarea>
                        <div class="centered mt2">
                            <input type="submit" class="button" name="enviar" value="Enviar">
                        </div>
                    </form>                    
                </section>
                <section class="flex1">
                    <h2>Ubicación y mapa</h2>
                    <iframe id="mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2985.640110090664!2d2.0555456109655594!3d41.55538897115919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4952ef0b8c6e9%3A0xb6f080d2f180b111!2sCIFO%20Valles!5e0!3m2!1ses!2ses!4v1760086069889!5m2!1ses!2ses" 
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <h3>Datos</h3>
                    <p><b>CIFO Sabadell</b> - Carretera Nacional 150, km. 15, 08227 Terrassa<br>
                    Teléfono: 93 736 29 10 <br>
                    Email: cifo_valles@gencat.cat</p>
                </section>
            </div>
            <br>
            <div class="centered">
                <a class="button" onclick="history.back()">Atrás</a>
            </div>
            <br>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>