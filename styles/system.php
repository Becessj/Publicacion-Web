<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    // Rastrea los recursos del sistema
    require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'system.php');
?>
