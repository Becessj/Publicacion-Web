<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Verifica si se recibieron los parámetros
    if (array_keys($_GET) !== array('uid', 'filename')) {
        // Muestra una página de error
        require_once(join_paths(ERROR_PATH, 'bad-request.php'));
        exit;
    }

    // Recupera los parámetros
    $uid = $_GET['uid'];
    $filename = $_GET['filename'];

    // Construye la ruta del archivo correspondiente
    $file = join_paths(STORAGE_PATH, 'documentos', $uid . '.pdf');

    // Verifica si no existe el archivo en la ruta obtenida
    if (!file_exists($file)) {
        require_once(join_paths(ERROR_PATH, 'not-found.php'));
        exit;
    }
    else {
        // Carga el archivo
        $content = file_get_contents($file);

        // Prepara al archivo para ser mostrado
        header('Content-Type: application/pdf');
        header('Content-Length: ' . strlen($content));
        header('Content-Disposition: inline; filename="' . urldecode($filename) . '.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        // Muestra el contenido del archivo
        exit($content);
    }
?>