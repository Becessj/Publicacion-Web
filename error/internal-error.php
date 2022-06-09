<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if (basename($_SERVER['REQUEST_URI']) === basename(__FILE__)) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    // Inicializa los recursos del sistema
    require_once('system.php');

    // Establece el código de estado HTTP
    http_response_code(500);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Metatags iniciales -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content=" IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Título de la página -->
        <title>Error interno</title>

        <!-- Hojas de estilos -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo BASE_URL . '/styles/error.css'; ?>" />
    </head>
    <body oncontextmenu="return false;">
        <div class="wrapper">
            <div class="content">
                <img class="img-responsive" src="<?php echo BASE_URL . '/images/not-found.png'; ?>" alt="icono" draggable="false" />
                <h2 class="text-primary">Error interno</h2>
                <p class="text-muted">Ha ocurrido un error y no fue posible procesar su solicitud.</p>
            </div>
        </div>
    </body>
</html>
