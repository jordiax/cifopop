<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Lista de users en <?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <title>Lista de users - <?= APP_NAME ?></title>
    </head>
    <body>
        <?= $template->login() ?>
        <?= $template->menu() ?>
        <?= $template->header('Lista de users') ?>
        <?= $template->breadCrumbs(['Panel del administrador'=>'/Panel/admin', 'Users'=>null]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME ?></h1>
            <h2>Lista completa de users</h2>
            <?php
            if($filtro)
            {
                // Agregamos el formulario con el botón de quitar filtro.
                echo $template->removeFilterForm($filtro, '/User/list');
            }
            else
            {
                echo $template->filterForm(
                    [ // Desplegable Buscar
                        'Nombre'=> 'displayname',
                        'Email'=> 'email',
                        'Teléfono'=> 'phone'
                    ],
                    [// Desplegabe Ordenar
                        'Nombre'=> 'displayname',
                        'Email'=> 'email',
                        'Teléfono'=> 'phone'
                    ],
                    'Nombre', 'Nombre');
            }
            if($users){ ?>
            <div class="right">
                <?= $paginator->stats() ?>
            </div>
            <div class="grid-list">
            <div class="grid-list-header">
                <span class="span2">Imagen:</span>
                <span class="span1">Nombre:</span> 
                <span class="span2">Email:</span>
                <span class="span1">Teléfono:</span>
                <span class="span3">Roles:</span>
                <span class="right">Operaciones</span>                    
            </div>
            <?php foreach ($users as $user){ ?>
                
                <div class="grid-list-item">
                    <a href="/User/show/<?= $user->id ?>" class="span2">
                        <img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>" class="table-image" alt="Imagen de <?= $user->displayname ?>">
                    </a>
                    <span data-label="displayname" class="span1"><?= $user->displayname ?></span>
                    <span class="span2"><a href="/User/show/<?= $user->id ?>" data-label="email"><?= $user->email ?></a></span>
                    <span data-label="phone" class="span1"><?= $user->phone ?></span>
                    <?php
                    $roles = '';
                    foreach($user->roles as $clave=>$valor)
                    {
                        $roles .= $valor.', ';                        
                    }
                    $roles = rtrim($roles, ', ');
                    ?>
                    <span data-label="roles" class="span1"><?= $roles ?></span>
                    <div class="right">
                    <a href="/User/show/<?= $user->id ?>">Ver</a>
                    <a href="/User/edit/<?= $user->id ?>">Editar</a>
                    <?php if(Login::isAdmin()){ ?>
                    <a href="/User/delete/<?= $user->id ?>">Eliminar</a>
                    <?php } ?>
                    </div>
                </div>
                
            <?php } ?>
            </div>
            <?= $paginator->ellipsisLinks() ?>
            <?php } 
            else{ ?>
                <div class="danger p2">
                    <p>"No hay users que mostrar.</p>
                </div>
            <?php } ?>
            <div class="centered">
                <a class="button" onclick="history.back()">Atrás</a>
            </div>
        </main>
        <?= $template->footer() ?>
		<?= $template->version() ?>
    </body>
</html>