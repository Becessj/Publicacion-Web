<?php
    // Inicializa los recursos del sistema
    require_once('system.php');
    
    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'AES', 'AES.php'));

    // Comprueba si no se ha iniciado sesión
    if (!sesion_activa()) {
        // Comprueba si se cuentan con los parametros requeridos
        if (isset($_GET['hash'], $_GET['et'], $_GET['eid'])) {
            // Recupera los parametros
            $hash = $_GET['hash'];
            $et = $_GET['et'];
            $eid = $_GET['eid'];

            // Desencipta el sello de tiempo
            $timestampDecryptor = new AES();
            $timestampDecryptor->setBlockSize(256);
            $timestampDecryptor->setKey(SYSTEM_KEY);
            $timestampDecryptor->setData($et);
            $timestamp = $timestampDecryptor->decrypt();

            // Recupera los valores de fecha y hora a partir del sello de tiempo
            $datetime = DateTime::createFromFormat('Y-m-d h:i:s', $timestamp);

            // Comprueba si el valores recuperados corresponden a una fecha y hora válidas
            if ($datetime and $datetime->format('Y-m-d h:i:s') == $timestamp) {
                // Si los valores son válidos, realiza una segunda verificación comprobando si el hash es válido
                if ($hash == md5($timestamp)) {
                    // Establece el período de vigencia del enlace de confirmación
                    $interval = DateInterval::createFromDateString('1 day');

                    // Calcula la hora límite de la vigencia del enlace
                    $deadline = DateTime::createFromFormat('Y-m-d h:i:s', $timestamp)->add($interval);

                    // Obtiene la fecha y hora actual
                    $now = new DateTime();

                    // Comprueba si el enlace aún está vigente
                    if ($now == max($datetime, min($now, $deadline))) {
                        // Establece que el restablecimiento de contraseña es a demanda del usuario
                        $_SESSION['RESET_ON_DEMAND'] = $eid;
                    }
                    else {
                        // El enlace ha expirado
                        set_result_message(LINK_HAS_EXPIRED);
                    }
                }
                else {
                    // El enlace no es válido
                    set_result_message(INVALID_LINK);
                }
            }
            else {
                // El enlace no es válido
                set_result_message(INVALID_LINK);
            }
        }
        else {
            // El enlace no es válido
            set_result_message(INVALID_LINK);
        }
    }
    else {
        // Ya ha iniciado sesión
        set_result_message(ALREADY_LOGGED_IN);
    }

    // Redirecciona al inicio
    header('Location: .');
?>