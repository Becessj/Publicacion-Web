<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Comprueba si se ha iniciado sesión
    if (sesion_activa()) {
        // Verifica si se ha iniciado sesión como administrador
        if (rol_usuario(sesion_activa()) == 'Administrador') {
            // Comprueba si se cuentan con los parámetros requeridos
            if (isset($_GET['ids'])) {
                // Recupera los parámetros
                $ids = json_decode($_GET['ids']);

                $success = 0;

                foreach ($ids as $id) {
                    // Elimina la cuenta de usuario
                    $result = eliminar_cuenta_usuario($id);

                    // Comprueba si la eliminación fue exitosa
                    if ($result) {
                        $success++;
                    }
                }
                
                // Verifica si todas las eliminaciones fueron exitosas
                if ($success === count($ids)) {
                    // Se eliminaron todos los registros
                    set_result_message(DELETE_MASS_SUCCESS);
                }
                elseif ($success > 0) {
                    // Se eliminaron algunos de los registros
                    set_result_message(DELETE_MASS_PARTIAL_SUCCESS);
                }
                else {
                    // No se eliminaron los registros
                    set_result_message(DELETE_MASS_FAILED);
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
