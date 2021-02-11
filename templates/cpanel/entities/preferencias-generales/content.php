<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    HtmlGen::comment('Preferencias generales', FALSE);

    // Corrige el nivel de indentación
    HtmlGen:: set_indent_level(3);

    HtmlGen::h3(array('class' => 'page-header'), 'Preferencias generales');

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

    // Recupera el contenido
    $configuracion = configuracion_pagina();
    $municipalidades = municipalidades();

    // Almacena localmente los datos recuperados
    HtmlGen::script('var configuracion = ' . json_encode($configuracion, JSON_NUMERIC_CHECK) . '; var municipalidades = ' . json_encode($municipalidades, JSON_NUMERIC_CHECK) . ';');

HtmlGen::form(array('action' => 'actualizar.php','method' => 'post'),function() use($municipalidades,$configuracion) {


    // Verifica si se ha iniciado sesión como administrador
    //if (rol_usuario($_SESSION['SESSION_TOKEN']) == 'Administrador') {
        HtmlGen::h4('Entidad');
	


        HtmlGen::h5('Nombre de Municipalidad');
        HtmlGen::select(array('id' => 'municipalidades','name' => 'municipalidades','class' => 'form-control'), function () use ($municipalidades,$configuracion) {
            foreach($municipalidades as $municipalidad){
		
		if ($configuracion['municipalidad'] == $municipalidad[1]){
		
		HtmlGen::option(array('id' => $municipalidad[0],'selected value' => $municipalidad[0]),$municipalidad[1]);
		}
		else{
		HtmlGen::option(array('id' => $municipalidad[0],'value' => $municipalidad[0]),$municipalidad[1]);
		}
                
        	}
            
        });

	HtmlGen::div(array(),function() use ($configuracion){

	  HtmlGen::br();
	  HtmlGen::br();   
    
        HtmlGen::h4('Apariencia');
        HtmlGen::h5('Color Principal');
        HtmlGen::input(array('type' => 'text', 'id' =>'colorprimario', 'name' =>'colorprimario', 'class' => 'form-control demo', 'data-control' => 'hue', 'value' => $configuracion['colorprimario']));
        HtmlGen::br(); 
        HtmlGen::h5('Color Secundario');
        HtmlGen::input(array('type' => 'text', 'id' =>'colorsecundario','name' =>'colorsecundario', 'class' => 'form-control demo', 'data-control' => 'hue', 'value' => $configuracion['colorsecundario']));
        HtmlGen::br(); 
        HtmlGen::h5('Color Base');
        HtmlGen::input(array('type' => 'text', 'id' =>'colorbase','name' =>'colorbase', 'class' => 'form-control demo', 'data-control' => 'hue', 'value' => $configuracion['colorbase']));
        HtmlGen::br(); 

	}); 

HtmlGen::div(array('class' => 'logout'), function () {
        HtmlGen::a('Actualizar', array('id' => 'actualizar','class' => 'btn btn-outline-danger','type' => 'submit'));
    });

}); 
   
        

    // Cuadros de diálogo
    require_once(join_paths(TEMPLATES_PATH, 'cpanel', 'entities', 'preferencias-generales', 'modals.php'));
?>
