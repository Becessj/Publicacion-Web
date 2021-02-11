<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    HtmlGen::comment('Barra de navegación');
    HtmlGen::nav(array('class' => 'navbar navbar-chrome'), function () {
        HtmlGen::div(array('class' => 'container'), function () {
            HtmlGen::comment('Botón de interacción con el menú en dispositivos móviles', FALSE);
            HtmlGen::div(array('class' => 'navbar-header'), function () {
                HtmlGen::button(array(
                    'type' => 'button',
                    'class' => 'navbar-toggle collapsed',
                    'data-toggle' => 'collapse',
                    'data-target' => '#navbar-collapse-cp'
                ), function () {
                    HtmlGen::span(array('class' => 'icon-bar'));
                    HtmlGen::span(array('class' => 'icon-bar'));
                    HtmlGen::span(array('class' => 'icon-bar'));
                });
            });
            HtmlGen::comment('Colección de elementos de la barra de navegación', FALSE);
            HtmlGen::div(array(
                'class' => 'collapse navbar-collapse',
                'id' => 'navbar-collapse-cp'
            ), function () {
                HtmlGen::ul(array('class' => 'nav navbar-nav'), function () {
                    HtmlGen::li(function () {
                        HtmlGen::a('RESEÑA HISTÓRICA', '#', array('data-anchor' => '#resena-historica'));
                    });
                    HtmlGen::li(function () {
                        HtmlGen::a('NOSOTROS', '#', array('data-anchor' => '#nosotros'));
                    });
                    HtmlGen::li(function () {
                        HtmlGen::a('PLAN DE ESTUDIOS', '#', array('data-anchor' => '#plan-estudios'));
                    });
                    HtmlGen::li(array('class' => 'visible-lg visible-md visible-xs'), function () {
                        HtmlGen::a('DOCENTES', '#', array('data-anchor' => '#docentes'));
                    });
                    HtmlGen::li(array('class' => 'visible-lg visible-md visible-xs'), function () {
                        HtmlGen::a('NOTICIAS', '#', array('data-anchor' => '#noticias'));
                    });
                    HtmlGen::li(array('class' => 'visible-lg visible-xs'), function () {
                        HtmlGen::a('GALERÍA', '#', array('data-anchor' => '#galeria'));
                    });
                    HtmlGen::li(array('class' => 'visible-lg visible-xs'), function () {
                        HtmlGen::a('DESCARGAS', '#', array('data-anchor' => '#descargas'));
                    });
                    HtmlGen::li(array('class' => 'visible-lg visible-xs'), function () {
                        HtmlGen::a('CONTACTO', '#', array('data-anchor' => '#contacto'));
                    });
                    HtmlGen::li(array(
                        'class' => 'dropdown hidden-lg hidden-xs',
                        'id' => 'mas'
                    ), function () {
                        HtmlGen::a(function () {
                            HtmlGen::span('MÁS');
                            HtmlGen::i(array('class' => 'fa fa-caret-down'));
                        }, '#', array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            'role' => 'button',
                            'aria-haspopup' => 'true',
                            'aria-expanded' => 'false'
                        ));
                        HtmlGen::ul(array('class' => 'dropdown-menu'), function () {
                            HtmlGen::li(array('class' => 'hidden-md'), function () {
                                HtmlGen::a('DOCENTES', '#', array('data-anchor' => '#docentes'));
                            });
                            HtmlGen::li(array('class' => 'hidden-md'), function () {
                                HtmlGen::a('NOTICIAS', '#', array('data-anchor' => '#noticias'));
                            });
                            HtmlGen::li(function () {
                                HtmlGen::a('GALERÍA', '#', array('data-anchor' => '#galeria'));
                            });
                            HtmlGen::li(function () {
                                HtmlGen::a('DESCARGAS', '#', array('data-anchor' => '#descargas'));
                            });
                            HtmlGen::li(function () {
                                HtmlGen::a('CONTACTO', '#', array('data-anchor' => '#contacto'));
                            });
                        });
                    });
                });
            });
        });
    });
?>