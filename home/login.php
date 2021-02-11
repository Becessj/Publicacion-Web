<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias


    // Comprueba si no se ha iniciado sesión
    if (!sesion_activa_user()) {
        // Comprueba si se cuentan con los parámetros requeridos
        if (isset($_POST['nombre-usuario'], $_POST['contrasena'])) {
            // Recupera los parámetros
            $nombre_usuario = $_POST['nombre-usuario'];
            $contrasena = $_POST['contrasena'];


                $credenciales_validas = verificar_credenciales($nombre_usuario, $contrasena);


                if ($credenciales_validas) {
                    // Recupera el token de sesión del usuario

                    $token = token_sesion_usuario($nombre_usuario);
                    //$token = token_sesion_usuario($nombre_usuario);
                    // Ratifica el inicio de sesión
                    iniciar_sesion_user($token,$nombre_usuario);
                }
                else {
                    // Credenciales no válidas
                    set_result_message(LOGIN_FAILED);
                }
            }

        
        else {
            // Solicitud no válida
            set_result_message(INVALID_REQUEST);
        }
    }
    else {
        // Ya ha iniciado sesión
        set_result_message(ALREADY_LOGGED_IN);
    }

    // Redirecciona al inicio
    header('Location: .');
?>