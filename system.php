<?php
    // Recursos del sistema

    // En este archivo se define la ubicación
    // de los recursos de sistema y los carga

    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    // Ruta de los recursos del sistema
    define('SYSTEM_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'system');

    // Inicializa el nucleo del sistema
    require_once(SYSTEM_PATH . DIRECTORY_SEPARATOR . 'core.php');
    
    // Inicializa el controlador de configuraciones
    require_once(SYSTEM_PATH . DIRECTORY_SEPARATOR . 'config.php');

    // Inicializa el controlador de base de datos
    require_once(SYSTEM_PATH . DIRECTORY_SEPARATOR . 'database.php');

    // Inicializa el controlador de banderas del sistema
    //require_once(SYSTEM_PATH . DIRECTORY_SEPARATOR . 'flags.php');

    // Inicializa el controlador de sesiones
    require_once(SYSTEM_PATH . DIRECTORY_SEPARATOR . 'session.php');
?>
