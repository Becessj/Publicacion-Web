<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Construye la ruta del archivo correspondiente
    $file = join_paths(STORAGE_PATH, 'entidad', 'resolucion.pdf');

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
        header('Content-Disposition: inline; filename="Resolución de plan de estudios.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        // Muestra el contenido del archivo
        exit($content);
    }
?>