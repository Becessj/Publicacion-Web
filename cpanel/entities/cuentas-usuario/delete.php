<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Comprueba si se ha iniciado sesión
    if (sesion_activa()) {
        // Verifica si se ha iniciado sesión como administrador
        if (rol_usuario(sesion_activa()) == 'Administrador') {
            // Comprueba si se cuentan con los parámetros requeridos
            if (isset($_GET['id'])) {
                // Recupera los parámetros
                $id = $_GET['id'];
                // Elimina la cuenta de usuario
                $result = eliminar_cuenta_usuario($id);

                // Comprueba si la eliminación fue exitosa
                if ($result) {
                    set_result_message(DELETE_SUCCESS);
                }
                else {
                    set_result_message(DELETE_FAILED);
                }
            }
            else {
                // Solicitud no válida
                set_result_message(INVALID_REQUEST);
            }
        }
        else {
            // Acceso denegado
            set_result_message(DENIED_ACCESS);
        }
    }
    else {
        // No ha iniciado sesión
        set_result_message(NOT_LOGGED_IN);
    }

    // Redirecciona al inicio
    header('Location: ../..');
?>
