<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'WideImage', 'WideImage.php'));

    // Verifica si se recibieron los parámetros
    if (array_keys($_GET) !== array('uid')) {
        // Muestra una página de error
        require_once(join_paths(ERROR_PATH, 'bad-request.php'));
        exit;
    }

    // Recupera los parámetros
    $uid = $_GET['uid'];

    // Construye la ruta del archivo correspondiente
    $file = join_paths(STORAGE_PATH, 'noticias', $uid . '.jpg');

    // Verifica si no existe el archivo en la ruta obtenida
    if (!file_exists($file)) {
        // Muestra la imagen alternativa de contingencia
        WideImage::load(join_paths(IMAGES_PATH, 'image-thumbnail-placeholder.png'))->output('png');
    }
    else {
        // Muestra la imagen
        WideImage::load($file)->resize(691, 389, 'outside')->crop('center', 'center', 691, 389)->output('jpg', 75);
    }
?>