<?php
    // Punto de entrada

    // Este archivo carga el sitio web a partir
    // de la interfaz seleccionada como inicial

    // Inicializa los módulos del sistema
    require_once('system.php');

    // Redirecciona a la ruta de inicio
    header('Location: ' . HOME_URL);
?>
