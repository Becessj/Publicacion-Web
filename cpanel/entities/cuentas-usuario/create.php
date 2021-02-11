<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'HtmlGen', 'lib.htmlgen.php'));
    require_once(join_paths(LIBRARIES_PATH, 'PHPMailer', 'PHPMailerAutoload.php'));

    // Establece la indentación para el código HTML generado dinámicamente
    HtmlGen::set_indent_pattern(INDENT_PATTERN);

    // Comprueba si se ha iniciado sesión
    if (sesion_activa()) {
        // Verifica si se ha iniciado sesión como administrador
        if (rol_usuario(sesion_activa()) == 'Administrador') {
            // Comprueba si se cuentan con los parámetros requeridos
            if (isset($_POST['nombre-usuario'])) {
                // Recupera los parámetros
                $nombre_usuario = $_POST['nombre-usuario'];
                // Crea la nueva cuenta de usuario y captura la contraseña
                $contrasena = crear_cuenta_usuario($nombre_usuario);

                // Comprueba si la creación fue exitosa
                if ($contrasena !== FALSE) {
                    // Recupera el nombre de la escuela profesional
                    $nombre_escuela = nombre_escuela();
                    // Prepara el mensaje de correo electrónico
                    ob_start();

                    HtmlGen::html(function () use ($nombre_escuela, $nombre_usuario, $contrasena) {
                        HtmlGen::body(function () use ($nombre_escuela, $nombre_usuario, $contrasena) {
                            HtmlGen::h4('Bienvenido a CPanel');
                            HtmlGen::p('Ahora usted está registrado como usuario del sistema CPanel para administrar el contenido del portal web de la escuela profesional de ' . $nombre_escuela . '.');
                            HtmlGen::p('Sus datos de acceso son los siguientes:');
                            HtmlGen::table(array('border' => '0'), function () use ($nombre_usuario, $contrasena) {
                                HtmlGen::tr(function () use ($nombre_usuario) {
                                    HtmlGen::th(array('style' => 'text-align: left; padding-right: 15px;'), 'Nombre de usuario:');
                                    HtmlGen::td($nombre_usuario);
                                });
                                HtmlGen::tr(function () use ($contrasena) {
                                    HtmlGen::th(array('style' => 'text-align: left; padding-right: 15px;'), 'Contraseña:');
                                    HtmlGen::td($contrasena);
                                });
                            });
                            HtmlGen::p(function () {
                                HtmlGen::span('Puede acceder a CPanel utilizando ');
                                HtmlGen::a('este enlace', BASE_URL . '/cpanel', array('target' => '_blank'));
                            });
                        });
                    });

                    $body = ob_get_contents();
                    ob_end_clean();

                    $altBody = 'Bienvenido a CPanel' . PHP_EOL;
                    $altBody .= 'Ahora usted está registrado como usuario del sistema CPanel para administrar el contenido del portal web de la escuela profesional de ' . $nombre_escuela . '.' . PHP_EOL;
                    $altBody .= 'Sus datos de acceso son los siguientes:';
                    $altBody .= 'Nombre de usuario: ' . $nombre_usuario;
                    $altBody .= 'Contraseña: ' . $contrasena;
                    $altBody .= 'Puede acceder a CPanel utilizando la siguiente dirección URL: ' . PHP_EOL;
                    $altBody .= BASE_URL . '/cpanel';

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
                    $mail->Subject = 'Bienvenido a CPanel';
                    $mail->Body = $body;
                    $mail->AltBody = $altBody;

                    if ($mail->send()) {
                        // Se envío el mensaje
                        set_result_message(REGISTER_SUCCESS);
                    }
                    else {
                        // No se pudo enviar el mensaje
                        set_result_message(PASSWORD_MAIL_FAILED);
                    }
                }
                else {
                    // No se pudo completar el registro
                    set_result_message(REGISTER_FAILED);
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

    // Redirecciona la página principal
    header('Location: ../..');
?>