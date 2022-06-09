<?php
    // Controlador de configuraciones

    // Este archivo gestiona los recursos
    // de configuración del sistema

    // Ruta de los recursos de configuración
    define('CONFIG_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config');

    // Inicializa las constantes de la aplicación
    require_once(CONFIG_PATH . DIRECTORY_SEPARATOR . 'app.php');

    // Inicializa los parámetros de correo electrónico
    require_once(CONFIG_PATH . DIRECTORY_SEPARATOR . 'mail.php');

    // Inicializa los parámetros de la base de datos
    require_once(CONFIG_PATH . DIRECTORY_SEPARATOR . 'database.php');

    // Inicializa las rutas predefinidas
    require_once(CONFIG_PATH . DIRECTORY_SEPARATOR . 'paths.php');
?>