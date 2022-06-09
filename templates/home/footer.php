<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    HtmlGen::comment('Pie de página', FALSE);

    // Corrige el nivel de indentación
    HtmlGen::set_indent_level(2);

    HtmlGen::div(array('id' => 'footer'), function () use ($lista_enlaces_externos, $plainTextFilter) {
        HtmlGen::div(array('class' => 'container'), function () use ($lista_enlaces_externos, $plainTextFilter) {
            // Verifica si hay enlaces externos en la lista
            if (count($lista_enlaces_externos) > 0) {
                // Muestra los enlaces externos
                HtmlGen::div(array('class' => 'text-center'), function () use ($lista_enlaces_externos, $plainTextFilter) {
                    foreach ($lista_enlaces_externos as $enlace_externo) {
                        HtmlGen::a(function () use ($enlace_externo, $plainTextFilter) {
                            HtmlGen::img(array(
                                'src' => 'logotipo-enlace-externo.php?id=' . $enlace_externo['Id'],
                                'alt' => $plainTextFilter->purify($enlace_externo['Titulo'])
                            ));
                        }, $plainTextFilter->purify($enlace_externo['Url']), array(
                            'class' => 'partner-item',
                            'target' => '_blank',
                            'title' => $plainTextFilter->purify($enlace_externo['Titulo']),
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top'
                        ));
                    }
                });
            }

            HtmlGen::p(array('id' => 'dev-info'), '&copy; 2017' . (intval(date('Y')) <= 2017 ? '' : ' - ' . date('Y')) . ' Red de Comunicaciones UNSAAC');
        });
    });
?>