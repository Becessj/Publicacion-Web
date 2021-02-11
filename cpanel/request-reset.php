<?php
    // Inicializa los recursos del sistema
    require_once('system.php');
    
    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'HtmlGen', 'lib.htmlgen.php'));
    require_once(join_paths(LIBRARIES_PATH, 'PHPMailer', 'PHPMailerAutoload.php'));
    require_once(join_paths(LIBRARIES_PATH, 'AES', 'AES.php'));

    // Establece la indentación para el código HTML generado dinámicamente
    HtmlGen::set_indent_pattern(INDENT_PATTERN);

    // Comprueba si no se ha iniciado sesión
    if (!sesion_activa()) {
        // Comprueba si se cuentan con los parametros requeridos
        if (isset($_POST['nombre-usuario'])) {
            // Recupera los parámetros
            $nombre_usuario = $_POST['nombre-usuario'];

            // Verifica el nombre de usuario
            $id = verificar_nombre_usuario($nombre_usuario);

            // Comprueba si se obtuvo un Id que corresponda al nombre de usuario
            if ($id !== FALSE) {
                // Recupera el nombre de la escuela profesional
                $nombre_escuela = nombre_escuela();

                // Encripta los parámetros de validación
                $timestamp = date('Y-m-d h:i:s');
                $hash = md5($timestamp);
                $timestampEncryptor = new AES();
                $timestampEncryptor->setBlockSize(256);
                $timestampEncryptor->setKey(SYSTEM_KEY);
                $timestampEncryptor->setData($timestamp);
                $et = $timestampEncryptor->encrypt();
                $idEncryptor = new AES();
                $idEncryptor->setBlockSize(256);
                $idEncryptor->setKey(SYSTEM_KEY);
                $idEncryptor->setData($id);
                $eid = $idEncryptor->encrypt();

                // Prepara un mensaje de correo electrónico de confirmación
                ob_start();

                HtmlGen::html(function () use ($hash, $et, $eid) {
                    HtmlGen::body(function () use($hash, $et, $eid) {
                        HtmlGen::h4('Restablecimiento de contraseña');
                        HtmlGen::p('Se ha recibido una solicitud para restablecer la contraseña de su cuenta de usuario.');
                        HtmlGen::p(function () use ($hash, $et, $eid) {
                            HtmlGen::span('Para confirmar su solicitud utilice ');
                            HtmlGen::a('este enlace', BASE_URL . '/cpanel/confirm.php?hash=' . $hash . '&et=' . urlencode($et) . '&eid=' . urlencode($eid), array('target' => '_blank'));
                        });
                        HtmlGen::p('Si usted no hizo esta solicitud, ignore este mensaje.');
                    });
                });

                $body = ob_get_contents();
                ob_end_clean();

                $altBody = 'Restablecimiento de contraseña' . PHP_EOL;
                $altBody .= 'Se ha recibido una solicitud para restablecer la contraseña de su cuenta de usuario.' . PHP_EOL;
                $altBody .= 'Para confirmar su solicitud utilice la siguiente dirección URL:' . PHP_EOL;
                $altBody .= BASE_URL . '/cpanel/confirm.php?hash=' . $hash . '&et=' . urlencode($et) . '&eid=' . urlencode($eid);

                $mail = new PHPMailer();
                    
                $mail->isSMTP();
                $mail->Host = MAIL_HOST;
                $mail->SMTPAuth = TRUE;
                $mail->Username = MAIL_USERNAME;
                $mail->Password = MAIL_PASSWORD;
                $mail->SMTPSecure = 'ssl';
                $mail->Port = MAIL_PORT;

                $mail->setFrom('no-reply@unsaac.edu.pe', 'Administrador de CPanel');
                $mail->addAddress($nombre_usuario . '@unsaac.edu.pe');

                $mail->isHTML(TRUE);
                $mail->CharSet = 'utf-8';
                $mail->Subject = 'Restablecimiento de contraseña';
                $mail->Body = $body;
                $mail->AltBody = $altBody;

                if ($mail->send()) {
                    // Se envío el mensaje
                    set_result_message(CONFIRM_MAIL_SENT);
                }
                else {
                    // No se pudo enviar el mensaje
                    set_result_message(CONFIRM_MAIL_FAILED);
                }
            }
            else {
                // Si no hay resultado, muestra un mensaje de error
                set_result_message(USERNAME_NOT_FOUND);
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