<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    HtmlGen::comment('Cuadro de introducción');
    HtmlGen::div(array(
        'class' => 'jumbotron',
        'id' => 'intro'
    ), function () use ($nombre_escuela, $url_logo, $plainTextFilter) {
        HtmlGen::div(array('class' => 'container'), function () use ($nombre_escuela, $url_logo, $plainTextFilter) {
            HtmlGen::img(array(
                'class' => 'img-responsive',
                'src' => $url_logo,
                'alt' => 'Logotipo',
                'id' => 'logo-escuela'
            ));
            HtmlGen::p(array(
                'class' => 'text-center',
                'id' => 'pre-nombre-escuela'
            ), 'Escuela profesional de');
            HtmlGen::p(array(
                'class' => 'text-center',
                'id' => 'nombre-escuela'
            ), $plainTextFilter->purify($nombre_escuela));
            HtmlGen::p(array('class' => 'text-center'), function () {
                HtmlGen::a('Continuar', '#', array(
                    'class' => 'btn btn-chrome',
                    'data-anchor' => '#resena-historica'
                ));
            });
        });
    });

    // Restablece el nivel de indentación
    HtmlGen::set_indent_level(0);
?>