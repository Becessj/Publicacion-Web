<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'HtmlGen', 'lib.htmlgen.php'));
    require_once(join_paths(LIBRARIES_PATH, 'HTMLPurifier', 'HTMLPurifier.auto.php'));


        $plainTextConfig = HTMLPurifier_Config::createDefault();
        $plainTextConfig->set('HTML.Allowed', '');
        $plainTextFilter = new HTMLPurifier($plainTextConfig);

        $richTextConfig = HTMLPurifier_Config::createDefault();
        $richTextFilter = new HTMLPurifier($richTextConfig); 

    // Carga las preferencias generales
    $configuracion = configuracion_pagina();

    // Comprueba si se ha iniciado sesión
    if (sesion_activa_user()) {
        // Si ya se ha iniciado sesión, redirecciona al panel de control
        header('Location: .');
    }
    else {
        // Establece la indentación para el código HTML generado dinámicamente
        HtmlGen::set_indent_pattern(INDENT_PATTERN);
    }


    $archivo_logo = join_paths(STORAGE_PATH, 'entidad', 'logo.png');

    // Verifica si no existe el archivo en la ruta obtenida
    if (!file_exists($archivo_logo)) {
        // Obtiene el URL de la imagen alternativa de contingencia
        $url_logo = BASE_URL . '/images/logo-placeholder.png';
    }
    else {
        // Obtiene el URL de la imagen
        $url_logo = BASE_URL . '/storage/entidad/logo.png';
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Metatags iniciales -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content=" IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Título de la página -->
        <title><?php echo $plainTextFilter->purify($configuracion['municipalidad']); ?></title>

        <!-- Icono de la página -->
        <link href="<?php echo $url_logo; ?>" rel="icon" type="image/png" />

        <!-- Hojas de estilos -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="../styles/login.css" />
        <link rel="stylesheet" href="../styles/home.php" />
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../images/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../images/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../images/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../images/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../images/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../images/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../images/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../images/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../images/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../images/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href=../images"/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="../images/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
    </head>
    
    <h2 class="page-header">
<a href="http://municalca.gob.pe" alt="Municipalidad Provincial de Calca">
<img class="logo-entidad" src="../images/log.png" width="120" height="120">
</a>
	<a href="http://municalca.gob.pe" alt="Municipalidad Provincial de Calca">
	<?php echo $plainTextFilter->purify($configuracion['municipalidad']); ?></h2>
	</a>
    <body class="bg-login none">
        <?php require_once(join_paths(TEMPLATES_PATH, 'tracking.php')); ?>
        <div class="container bg-default login-menu">
            <div class="row">
                <div class="col-md-12">
                    
                    <h3 class="page-header">Módulo de Consulta de Estado de Cuenta</h3>
                    <?php
                        // Comprueba si hay un mensaje de resultado pendiente
                        if (exists_result_message()) {
                            $message = get_result_message();

                            // Prepara la alerta según el mensaje obtenido
                            switch($message) {
                                case LOGIN_FAILED:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case NOT_LOGGED_IN:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case USERNAME_NOT_FOUND:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case CONFIRM_MAIL_SENT:
                                    $context = 'warning';
                                    $icon = 'exclamation-triangle';
                                    break;
                                case CONFIRM_MAIL_FAILED:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case NEW_PASSWORD_SENT:
                                    $context = 'success';
                                    $icon = 'check-circle';
                                    break;
                                case NEW_PASSWORD_MAIL_FAILED:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case LINK_HAS_EXPIRED:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case INVALID_LINK:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case REQUEST_AUTHENTICATION_FAILED:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                                case INVALID_REQUEST:
                                    $context = 'danger';
                                    $icon = 'times-circle';
                                    break;
                            }

                            // Alerta
                            HtmlGen::div(array(
                                'class' => 'alert alert-' . $context . ' fade in',
                                'role' => 'alert'
                            ), function () use ($icon, $message) {
                                // Corrige el nivel de indentación
                                HtmlGen::set_indent_level(6);

                                HtmlGen::button(array(
                                    'class' => 'close',
                                    'data-dismiss' => 'alert'
                                ), '&times;');
                                HtmlGen::i(array('class' => 'fa fa-' . $icon . ' fa-lg fa-fw'));
                                HtmlGen::span($message);
                            });

                            // Restablece el nivel de indentación
                            HtmlGen::set_indent_level(0);

                            // Elimina el mensaje de resultado
                            unset_result_message();
                        }
                    ?>
                    <form action="login.php" method="post" id="form-login" data-toggle="validator">
                        <div class="form-group">
                            <label for="nombre-usuario" class="control-label">Nombre de usuario</label>
                            <input type="text" class="form-control" name="nombre-usuario" required />
                        </div>
                        <div class="form-group">
                            <label for="contrasena" class="control-label">Contraseña</label>
                            <input type="password" class="form-control" name="contrasena" required />
                        </div>
                        <!--<div class="form-group">
                            <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_PUBLIC_KEY; ?>"></div>
                        </div> -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

	<div id = 'footer' class = 'footer'>
	<h6 class = 'footer-detail'>Copyright. © Derechos reservados.</h6>
        <h6 class = 'footer-detail'>Centro Guamán Poma de Ayala - 2019</h6>
        </div>



        <!-- Cuadro de diálogo Solicitar restablecimiento de contrasena -->
        <div class="modal fade" id="solicitar-restablecimiento-contrasena" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitar restablecimiento de contraseña</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="request-reset.php" id="form-solicitar-restablemiento-contrasena">
                            <div class="form-group">
                                <label for="nombre-usuario" class="control-label">Ingrese su nombre de usuario</label>
                                <input type="text" class="form-control" name="nombre-usuario" maxlength="240" required />
                                <p class="help-block with-errors"></p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-submit" data-target="#form-solicitar-contrasena">Enviar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-captcha" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Error</h4>
                    </div>
                    <div class="modal-body">
                        <p>Debe marcar la casilla para verificar la autenticidad de su solicitud.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Scripts -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.9.0/validator.min.js"></script>
        <script src="../scripts/cpanel.js"></script>
    </body>
</html>
