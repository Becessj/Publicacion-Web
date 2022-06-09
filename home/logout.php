<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Cierra la sesión
    cerrar_sesion();

    // Redirecciona al inicio
    header('Location: .');
?>