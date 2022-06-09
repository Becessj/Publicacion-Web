<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    HtmlGen::comment('Encabezado de la página', FALSE);

    // Corrige el nivel de indentación
    HtmlGen::set_indent_level(3);

    HtmlGen::div(array('id' => 'header'), function () {
        HtmlGen::div(array('class' => 'container'), function () {
            HtmlGen::a('', 'http://www.unsaac.edu.pe', array('id' => 'header-main-link'));
            HtmlGen::div(array('id' => 'header-shortcuts'), function () {
                HtmlGen::div(array('class' => 'icon-wrapper'), function () {
                    HtmlGen::a(function () {
                        HtmlGen::span(array('class' => 'fa-stack fa-lg'), function () {
                            HtmlGen::i(array('class' => 'fa fa-circle-thin fa-stack-2x'));
                            HtmlGen::i(array('class' => 'fa fa-facebook fa-stack-1x'));
                        });
                    }, 'https://www.facebook.com/UNSAACPag.Oficial/', array(
                        'id' => 'shortcut-facebook',
                        'target' => '_blank',
                        'title' => 'Fanpage en Facebook',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom'
                    ));
                    HtmlGen::a(function () {
                        HtmlGen::span(array('class' => 'fa-stack fa-lg'), function () {
                            HtmlGen::i(array('class' => 'fa fa-circle-thin fa-stack-2x'));
                            HtmlGen::i(array('class' => 'fa fa-youtube-play fa-stack-1x'));
                        });
                    }, 'https://www.youtube.com/channel/UCUciZgc1RYS55ki7FgMQ0Bw', array(
                        'id' => 'shortcut-youtube',
                        'target' => '_blank',
                        'title' => 'Canal de Youtube',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom'
                    ));
                    HtmlGen::a(function () {
                        HtmlGen::span(array('class' => 'fa-stack fa-lg'), function () {
                            HtmlGen::i(array('class' => 'fa fa-circle-thin fa-stack-2x'));
                            HtmlGen::i(array('class' => 'fa fa-envelope-o fa-stack-1x'));
                        });
                    }, 'http://correo.unsaac.edu.pe/', array(
                        'id' => 'shortcut-mail',
                        'target' => '_blank',
                        'title' => 'Accede al correo electrónico',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom'
                    ));
                    HtmlGen::a(function () {
                        HtmlGen::span(array('class' => 'fa-stack fa-lg'), function () {
                            HtmlGen::i(array('class' => 'fa fa-circle-thin fa-stack-2x'));
                            HtmlGen::i(array('class' => 'fa fa-phone fa-stack-1x'));
                        });
                    }, 'http://www.unsaac.edu.pe/universidad/directorio', array(
                        'id' => 'shortcut-phone',
                        'target' => '_blank',
                        'title' => 'Directorio telefónico',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom'
                    ));
                });
            });
        });
    });
?>
