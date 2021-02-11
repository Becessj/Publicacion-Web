<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }
?>

        <!-- Barra de navegación lateral -->
        <nav class="navbar navbar-inverse navbar-side">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-cpanel">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#" data-toggle="modal" data-target="#modal-about"><i class="fa fa-cog fa-lg fa-fw"></i>CPanel</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse-cpanel">
                    <?php
                        // Enlaces de la barra de navegación
                        HtmlGen::ul(array('class' => 'nav navbar-nav'), function () use ($pages) {
                            // Corrige el nivel de indentación
                            HtmlGen::set_indent_level(6);/*
                            foreach ($pages as $index => $page) {
                                // Realiza una evaluación para determinar si el enlace a la página se mostrará en la barra de navegación
                                if (TRUE and (rol_usuario($_SESSION['SESSION_TOKEN']) == 'Administrador' or !$page['requireSpecialPermissons']))
                                // El enlace se mostrará en caso de no requerir permisos especiales y en caso de requerirlos, sólo si el usuario actual cuenta con ellos
                                HtmlGen::li(isset($_SESSION['SELECTED_PAGE']) ? ($_SESSION['SELECTED_PAGE'] == $index ? array('class' => 'active') : array()) : ($index == 0 ? array('class' => 'active') : array()), function () use ($index, $page) {
                                    HtmlGen::a(function () use ($page) {
                                        HtmlGen::i(array('class' => 'fa fa-' . $page['faIcon'] . ' fa-lg fa-fw'));
                                        HtmlGen::span($page['title']);
                                    }, '.?target=' . $index);
                                });
                            }
                            */
                            // Enlace para cerrar sesión
                            HtmlGen::li(function () {
                                HtmlGen::a(function () {
                                    HtmlGen::i(array('class' => 'fa fa-power-off fa-lg fa-fw'));
                                    HtmlGen::span('Cerrar sesión');
                                }, 'logout.php');
                            });
                        });

                        // Restablece el nivel de indentación
                        HtmlGen::set_indent_level(0);
                    ?>
                </div>
            </div>
        </nav>
