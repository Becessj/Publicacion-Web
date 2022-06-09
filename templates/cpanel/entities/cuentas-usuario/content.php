<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    HtmlGen::comment('Cuentas de usuario', FALSE);

    // Corrige el nivel de indentación
    HtmlGen::set_indent_level(3);

    HtmlGen::h3(array('class' => 'page-header'), 'Cuentas de usuario');

    // Comprueba si se recibió un mensaje de resultado
    if (isset($message)) {
        // Alerta
        HtmlGen::div(array(
            'class' => 'alert alert-' . $context . ' fade in',
            'role' => 'alert'
        ), function () use ($icon, $message) {
            HtmlGen::button(array(
                'class' => 'close',
                'data-dismiss' => 'alert'
            ), '&times;');
            HtmlGen::i(array('class' => 'fa fa-' . $icon . ' fa-lg fa-fw'));
            HtmlGen::span($message);
        });

        // Elimina el mensaje de resultado
        unset_result_message();
    }

    HtmlGen::p('Lista completa de cuentas de usuarios registrados.');
    HtmlGen::div(array('class' => 'form-group'), function () {
        HtmlGen::button(array(
            'type' => 'button',
            'class' => 'btn btn-primary',
            'data-toggle' => 'modal',
            'data-target' => '#crear-cuenta'
        ), 'Crear cuenta');
        HtmlGen::button(array(
            'type' => 'button',
            'class' => 'btn btn-default hidden',
            'id' => 'btn-eliminar-cuentas',
            'data-toggle' => 'modal',
            'data-target' => '#eliminar-cuentas',
            'data-enabler' => 'cuentas'
        ), 'Eliminar');
    });

    // Recupera el contenido
    $cuentas = cuentas_administrables();

    // Verifica si se registraron cuentas de usuario
    if (count($cuentas) > 0) {
        HtmlGen::div(array('class' => 'table-responsive'), function () use ($cuentas, $plainTextFilter) {
            HtmlGen::table(array('class' => 'table table-hover'), function () use ($cuentas, $plainTextFilter) {
                // Encabecado de la tabla
                HtmlGen::tr(function () {
                    HtmlGen::th(array('class' => 'bg-primary text-center'), function () {
                        HtmlGen::input(array(
                            'type' => 'checkbox',
                            'data-toggle' => 'checkall',
                            'data-target' => 'cuentas'
                        ));
                    });
                    HtmlGen::th(array('class' => 'bg-primary col-xs-11'), 'Nombre de usuario');
                    HtmlGen::th(array('class' => 'bg-primary text-center col-xs-1'), 'Opciones');
                });

                // Contenido de la tabla
                foreach ($cuentas as $cuenta) {
                    HtmlGen::tr(function () use ($cuenta, $plainTextFilter) {
                        HtmlGen::td(array('class' => 'text-center'), function () use ($cuenta) {
                            HtmlGen::input(array(
                                'type' => 'checkbox',
                                'data-check-group' => 'cuentas',
                                'data-value' => $cuenta['Id']
                            ));
                        });
                        HtmlGen::td($plainTextFilter->purify($cuenta['NombreUsuario']));
                        HtmlGen::td(array('class' => 'text-center'), function () use ($cuenta) {
                            HtmlGen::a(function () {
                                HtmlGen::i(array('class' => 'fa fa-refresh fa-fw text-primary'));
                            }, '#', array(
                                'data-toggle' => 'modal',
                                'data-target' => '#restablecer-contrasena',
                                'title' => 'Restablecer contraseña',
                                'data-id' => $cuenta['Id'],
                                'data-tooltip' => '',
                                'data-placement' => 'top'
                            ));
                            HtmlGen::a(function () {
                                HtmlGen::i(array('class' => 'fa fa-times fa-fw text-danger'));
                            }, '#', array(
                                'data-toggle' => 'modal',
                                'data-target' => '#eliminar-cuenta',
                                'title' => 'Eliminar',
                                'data-id' => $cuenta['Id'],
                                'data-tooltip' => '',
                                'data-placement' => 'top'
                            ));
                        });
                    });
                }
            });
        });
    }

    // Cuadros de diálogo
    require_once(join_paths(TEMPLATES_PATH, 'cpanel', 'entities', 'cuentas-usuario', 'modals.php'));
?>
