<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'WideImage', 'WideImage.php'));

    // Verifica si se recibieron los parámetros
    if (array_keys($_GET) !== array('id')) {
        // Muestra una página de error
        require_once(join_paths(ERROR_PATH, 'bad-request.php'));
        exit;
    }

    // Recupera los parámetros
    $id = $_GET['id'];

    // Construye la ruta del archivo correspondiente
    $file = join_paths(STORAGE_PATH, 'entidad', 'partner-' . $id . '.png');

    // Verifica si no existe el archivo en la ruta obtenida
    if (!file_exists($file)) {
        // Muestra la imagen alternativa de contingencia
        WideImage::load(join_paths(IMAGES_PATH, 'partner-logo-placeholder.png'))->output('png');
    }
    else {
        // Muestra la imagen
        WideImage::load($file)->output('png');
    }
?>