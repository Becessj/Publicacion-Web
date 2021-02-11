<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'WideImage', 'WideImage.php'));
    require_once(join_paths(LIBRARIES_PATH, 'HtmlGen', 'lib.htmlgen.php'));
    require_once(join_paths(LIBRARIES_PATH, 'HTMLPurifier', 'HTMLPurifier.auto.php'));

    // Carga las preferencias generales
    $configuracion = configuracion_pagina();

    // Comprueba si se ha iniciado sesión
    if (sesion_activa_cpanel()) {
        // Construye la ruta del archivo que contiene la lista de páginas del Panel de control
        $file = join_paths(TEMPLATES_PATH, 'cpanel', 'navbar.json');
        // Verifica si eciste el archivo
        if (file_exists($file)) {
            // Si existe, recupera su contenido
            $json = file_get_contents($file);

            // Recupera la lista de páginas
            $pages = json_decode($json, TRUE);

            // Comprueba si seleccionó una nueva página
            if (isset($_GET['target'])) {
                $target = intval($_GET['target']);
                // Comprueba si el objetivo está dentro del rango de indices de las páginas
                if (in_array($target, array_keys($pages))) {
                    // Si el objetivo está dentro del rango, lo guarda y hace la redirección
                    $_SESSION['SELECTED_PAGE'] = $target;
                    header('Location: .');
                }
                else {
                    // Si el objetivo está fuera del rango, vuelve a la página anterior
                    header('Location: .');
                }
            }
            else {
                // Comprueba si se ha realizado una redirección
                if (isset($_SESSION['SELECTED_PAGE'])) {
                    // Construye la ruta de la plantilla para la página seleccionada
                    switch ($_SESSION['SELECTED_PAGE']) {
                        case 0:
                            $entity = 'preferencias-generales';
                            break;
                        case 1: 
                            $entity = 'cuentas-usuario';
                            break;

                    }

                    $side_content = join_paths(TEMPLATES_PATH, 'cpanel', 'entities', $entity, 'content.php');
                }
                else {
                    // Construye la ruta de la plantilla para la página por defecto
                    $side_content = join_paths(TEMPLATES_PATH, 'cpanel', 'entities', 'preferencias-generales', 'content.php');
                }
            }
        }
        else {
            die('ERROR: No se ha podido encontrar el rucurso necesario para establecer las páginas de administración.');
        }

        // Establece la indentación para el código HTML generado dinámicamente
        HtmlGen::set_indent_pattern(INDENT_PATTERN);

        // Inicializa los filtros de saneamiento
        $plainTextConfig = HTMLPurifier_Config::createDefault();
        $plainTextConfig->set('HTML.Allowed', '');
        $plainTextFilter = new HTMLPurifier($plainTextConfig);

        $richTextConfig = HTMLPurifier_Config::createDefault();
        $richTextFilter = new HTMLPurifier($richTextConfig);

        // Construye la ruta del archivo correspondiente al logotipo de la escuela profesional
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

        // Comprueba si hay un mensaje de resultado pendiente
        if (exists_result_message()) {
            $message = get_result_message();

            // Prepara la alerta según el mensaje obtenido
            switch ($message) {
                case ALREADY_LOGGED_IN:
                    $context = 'warning';
                    $icon = 'exclamation-triangle';
                    break;
                case NEW_PASSWORD_MAIL_FAILED:
                    $context = 'warning';
                    $icon = 'exclamation-triangle';
                    break;
                case NEW_PASSWORD_SENT:
                    $context = 'success';
                    $icon = 'check-circle';
                    break;
                case RESET_PASSWORD_SUCCESS:
                    $context = 'success';
                    $icon = 'check-circle';
                    break;
                case RESET_PASSWORD_FAILED:
                    $context = 'warning';
                    $icon = 'exclamation-triangle';
                    break;
                case DENIED_ACCESS:
                    $context = 'danger';
                    $icon = 'times-circle';
                    break;
                case REGISTER_SUCCESS:
                    $context = 'success';
                    $icon = 'check-circle';
                    break;
                case REGISTER_FAILED:
                    $context = 'danger';
                    $icon = 'times-circle';;
                    break;
                case PASSWORD_MAIL_FAILED:
                    $context = 'warning';
                    $icon = 'exclamation-triangle';
                    break;
                case EDIT_SUCCESS:
                    $context = 'success';
                    $icon = 'check-circle';
                    break;
                case EDIT_FAILED:
                    $context = 'danger';
                    $icon = 'times-circle';
                    break;
                case DELETE_SUCCESS:
                    $context = 'success';
                    $icon = 'check-circle';
                    break;
                case DELETE_FAILED:
                    $context = 'danger';
                    $icon = 'times-circle';
                    break;
                case DELETE_MASS_FAILED:
                    $context = 'danger';
                    $icon = 'times-circle';
                    break;
                case DELETE_MASS_PARTIAL_SUCCESS:
                    $context = 'success';
                    $icon = 'check-circle';
                    break;
                case DELETE_MASS_SUCCESS:
                    $context = 'success';
                    $icon = 'check-circle';
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
        }
    }
    elseif (isset($_SESSION['RESET_ON_DEMAND'])) {
        header('Location: entities/cuentas-usuario/reset.php');
    }
    else {
        header('Location: inicio.php');
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
        <title>Panel de control</title>

        <!-- Icono de la página -->
        <link href="<?php echo $url_logo; ?>" rel="icon" type="image/png" />

        <!-- Hojas de estilos -->
	
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" />
        <link rel="stylesheet" href="../styles/loader-spinner.css" />
        <link rel="stylesheet" href="../styles/cpanel.css" />

<meta name="author" content="Jake Rocheleau">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="shortcut icon" href="http://www.templatemonster.com/favicon.ico">
  <link rel="icon" href="http://www.templatemonster.com/favicon.ico">
  <link rel="stylesheet" type="text/css" media="all" href="css/jquery.minicolors.css">
  
  
    </head>
    <body>
        <?php
            require_once(join_paths(TEMPLATES_PATH, 'tracking.php'));
            require_once(join_paths(TEMPLATES_PATH, 'cpanel', 'loader.php'));
            require_once(join_paths(TEMPLATES_PATH, 'cpanel', 'navbar.php'));
        ?>
        <div class="side-content">
            <?php
                if (file_exists($side_content)) {
                    require_once($side_content);
                }
                else {
                    HtmlGen::h3(array('class' => 'page-header'), 'Página no encontrada');
                    // Corrige el nivel de indentación
                    HtmlGen::set_indent_level(3);
                    // Muestra el mensaje de error
                    HtmlGen::p(PAGE_NOT_FOUND);
                    // Restablece el nivel de indentación
                    HtmlGen::set_indent_level(0);
                }
            ?>
        </div>

        <!-- Cuadro de diálogo Acerca de CPanel -->
        <div class="modal fade" id="modal-about" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Acerca de CPanel</h4>
                    </div>
             
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.9.0/validator.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-es_CL.min.js"></script>
        <script src="../scripts/tinymce/tinymce.min.js"></script>
        <script src="../scripts/functions.js"></script>
        <script src="../scripts/cpanel.js"></script>
	<script type="text/javascript">
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="js/jquery.minicolors.min.js"></script>
<script>
$(function(){
  var colpick = $('.demo').each( function() {
    $(this).minicolors({
      control: $(this).attr('data-control') || 'hue',
      inline: $(this).attr('data-inline') === 'true',
      letterCase: 'lowercase',
      opacity: false,
      change: function(hex, opacity) {
        if(!hex) return;
        if(opacity) hex += ', ' + opacity;
        try {
          console.log(hex);
        } catch(e) {}
        $(this).select();
      },
      theme: 'bootstrap'
    });
  });
  
  var $inlinehex = $('#inlinecolorhex h3 small');
  $('#inlinecolors').minicolors({
    inline: true,
    theme: 'bootstrap',
    change: function(hex) {
      if(!hex) return;
      $inlinehex.html(hex);
    }
  });
});
</script>
    </body>
</html>
