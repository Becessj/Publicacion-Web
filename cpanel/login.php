<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'ReCaptcha', 'ReCaptcha.php'));

    // Comprueba si no se ha iniciado sesión
    if (!sesion_activa_cpanel()) {
        // Comprueba si se cuentan con los parámetros requeridos
        if (isset($_POST['nombre-usuario'], $_POST['contrasena'])) {
            // Recupera los parámetros
            $nombre_usuario = $_POST['nombre-usuario'];
            $contrasena = $_POST['contrasena'];
            
        
            // Verifica la autenticidad de la solicitud
            //$capctcha = new ReCaptcha(CAPTCHA_PRIVATE_KEY);
            //$response = $capctcha->verify($gRecaptchaResponse);

            if (True) {
                // Comprueba si los datos ingresados son credenciales válidas
                $credenciales_validas = verificar_administrador($nombre_usuario, $contrasena);

                if ($credenciales_validas) {
                    iniciar_sesion_cpanel('cpanel','admin');
               }
                else {
                    // Credenciales no válidas
                    set_result_message(LOGIN_FAILED);
                }
           }
            else {
                // Error de autenticidad de solicitud
                set_result_message(REQUEST_AUTHENTICATION_FAILED);
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