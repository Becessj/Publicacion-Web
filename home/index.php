<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'WideImage', 'WideImage.php'));
    require_once(join_paths(LIBRARIES_PATH, 'HtmlGen', 'lib.htmlgen.php'));
    require_once(join_paths(LIBRARIES_PATH, 'HTMLPurifier', 'HTMLPurifier.auto.php'));

    if (sesion_activa_user()) {
    // Carga las preferencias generales
    $configuracion = configuracion_pagina();
    $cant_menu = 1;
    
    $nombre_usuario = $_SESSION['user_id'];

    $contribuyente = contribuyente($nombre_usuario);
    $impuesto_predial = impuesto_predial($nombre_usuario);

    $limpieza_publica= limpieza_publica($nombre_usuario);

    $resumen_general = resumen_general($nombre_usuario);
  
    $servicio_agua = servicio_agua($nombre_usuario);
    $periodo_anterior = "";

    if(count($impuesto_predial) > 0){
        $cant_menu += 1;
    }

    if(count($limpieza_publica) > 0){
        $cant_menu += 1;
    }

    if(count($servicio_agua) > 0){
        $cant_menu += 1;
    }

    $menu = 12/$cant_menu;
 
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
        $url_logo = '../images/logo-placeholder.png';
    }
    else {
        // Obtiene el URL de la imagen
        $url_logo = '../images/santiago.jpg';
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

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <!-- Metatags de Facebook -->
        <meta property="og:site_name" content="<?php echo $plainTextFilter->purify($configuracion['municipalidad']); ?>" />
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?php echo HOME_URL; ?>" />
        <meta property="og:image" content="<?php echo $url_logo; ?>" />
        <meta property="og:image:width" content="200" />
        <meta property="og:image:height" content="200" />
        <meta property="og:title" content=" <?php echo $plainTextFilter->purify($configuracion['municipalidad']); ?>" />

        <!-- Título de la página -->
        <title> <?php echo $plainTextFilter->purify($configuracion['municipalidad']); ?></title>

        <!-- Icono de la página -->
        <link href="<?php echo $url_logo; ?>" rel="icon" type="image/png" />

        <!-- Hojas de estilos -->
        <link rel="stylesheet" href="../styles/slider/css/my-slider.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900%7CLato%7CMuli" />
        <link rel="stylesheet" href="../styles/lightbox.min.css" type="text/css"/>
        <link rel="stylesheet" href="../styles/home.php" type="text/css"/>
        <link rel="stylesheet" href="../styles/aos.css" type="text/css" />
        <link rel="stylesheet" href="../styles/slider/style.css" type="text/css" />
        <link rel="stylesheet" href="../styles/loader-spinner.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        
    </head>


<body>

   <?php
    require_once(join_paths(TEMPLATES_PATH, 'tracking.php'));
    require_once(join_paths(TEMPLATES_PATH, 'cpanel', 'loader.php'));



    
    HtmlGen::img(array('class' => 'logo-entidad', 'src'=>'../images/log.png', 'width'=> '120','height'=>'120' ));
    HtmlGen::h2(array('class' => 'page-header'), 'Módulo de Publicación de Cuentas de la '. $plainTextFilter->purify($configuracion['municipalidad']));

    HtmlGen::div(array('class' => 'logout'), function () {
        HtmlGen::a('Cerrar Sesion', 'logout.php', array('id' => 'cerrarsesion','class' => 'btn btn-outline-danger'));
    });

    HtmlGen::div(array('class' => 'container'), function() use ($contribuyente, $plainTextFilter) {
        HtmlGen::div(array('class' => 'div_informacion'), function() use ($contribuyente, $plainTextFilter) {
            HtmlGen::h4(array('class' => 'info-page'), 'Bienvenido '. $plainTextFilter->purify($contribuyente['nombre']));
            HtmlGen::h5(array('class' => 'info-page'), 'DNI : '. $plainTextFilter->purify($contribuyente['clave']));
            HtmlGen::h5(array('class' => 'info-page'), 'Dirección : '. $plainTextFilter->purify($contribuyente['direccion']));
        });
    });


    HtmlGen::div(array('id' => 'data-information','class' => 'container'), function () use ($impuesto_predial,$limpieza_publica,$servicio_agua,$menu) {

        HtmlGen::div(array('class' => 'row'), function () use ($impuesto_predial,$limpieza_publica,$servicio_agua,$menu){
                

                HtmlGen::div(array('id' => 'item0',
                               'class' => 'col-md-'.$menu,
                               'style' => 'text-align:center;height:250px;margin-bottom:10px;'), function () use ($impuesto_predial,$limpieza_publica,$servicio_agua){
                HtmlGen::div(array('id' => 'item-0',
                                   'class' => 'div-item',
                                   'onclick' => 'openItem(event,"resumen_general")'), function() use ($impuesto_predial,$limpieza_publica,$servicio_agua) {
                    HtmlGen::svg(array(
                        'id' => 'svg-item-0',
                        'class' => 'svg-item',
                        'viewBox' => '0 0 570 570',
                        'style' => ''), function(){
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M310.634,43.714H297.17c-7.194,0-13.026-5.833-13.026-13.026V30.25C284.144,13.543,270.6,0,253.893,0h-0.699   c-16.707,0-30.25,13.543-30.25,30.25v0.438c0,7.194-5.833,13.027-13.026,13.027h-13.464c-14.341,0-25.966,11.625-25.966,25.966   v0.525c0,14.341,11.625,25.966,25.966,25.966h114.183c14.34,0,25.965-11.626,25.965-25.966V69.68   C336.601,55.34,324.976,43.714,310.634,43.714z M253.543,43.714c-7.243,0-13.114-5.872-13.114-13.114   c0-7.243,5.872-13.115,13.114-13.115c7.243,0,13.114,5.872,13.114,13.115C266.657,37.843,260.786,43.714,253.543,43.714z    M311.929,550.8H91.8c-19.314,0-34.971-15.657-34.971-34.971V96.171c0-19.314,15.657-34.971,26.228-34.971h70.854   c-0.591,2.904-0.91,5.914-0.91,9.008c0,23.958,19.492,43.45,43.454,43.45h114.178c23.963,0,43.453-19.492,43.453-43.979   c0-2.903-0.311-5.733-0.855-8.479h53.312c28.059,0,43.715,15.657,43.715,34.971v262.728c-2.906-0.181-5.791-0.442-8.742-0.442   c-12.094,0-23.771,1.704-34.973,4.604V157.371H100.543v349.715h201.528C303.029,522.453,306.387,537.162,311.929,550.8z    M441.515,384.686c-62.771,0-113.656,50.887-113.656,113.657S378.743,612,441.515,612s113.656-50.887,113.656-113.657   S504.286,384.686,441.515,384.686z M515.782,474.991l-69.943,78.686c-3.445,3.877-8.244,5.865-13.076,5.865   c-3.838,0-7.697-1.255-10.916-3.833l-43.715-34.971c-7.539-6.028-8.764-17.034-2.727-24.573c6.027-7.547,17.037-8.769,24.576-2.731   l30.748,24.598l58.916-66.28c6.408-7.215,17.465-7.872,24.684-1.451C521.55,456.721,522.198,467.769,515.782,474.991z M362.829,306   H222.944c-4.829,0-8.743-3.915-8.743-8.743v-8.743c0-4.829,3.914-8.743,8.743-8.743h139.885c4.828,0,8.744,3.915,8.744,8.743v8.743   C371.571,302.085,367.657,306,362.829,306z M362.829,227.314H222.944c-4.829,0-8.743-3.915-8.743-8.743v-8.743   c0-4.829,3.914-8.743,8.743-8.743h139.885c4.828,0,8.744,3.915,8.744,8.743v8.743C371.571,223.4,367.657,227.314,362.829,227.314z    M319.114,375.943h-96.17c-4.829,0-8.743-3.915-8.743-8.743v-8.743c0-4.829,3.914-8.743,8.743-8.743h96.17   c4.83,0,8.744,3.914,8.744,8.743v8.743C327.856,372.028,323.944,375.943,319.114,375.943z M301.629,454.629h-78.686   c-4.829,0-8.743-3.915-8.743-8.743v-8.743c0-4.829,3.914-8.743,8.743-8.743h78.686c4.829,0,8.743,3.914,8.743,8.743v8.743   C310.372,450.714,306.458,454.629,301.629,454.629z M197.461,194.981l-32.199,36.224c-1.586,1.785-3.795,2.701-6.02,2.701   c-1.767,0-3.543-0.578-5.025-1.765l-20.125-16.099c-3.471-2.775-4.034-7.841-1.256-11.312c2.774-3.475,7.844-4.037,11.314-1.258   l14.155,11.323l27.123-30.513c2.95-3.321,8.04-3.624,11.363-0.668C200.117,186.57,200.415,191.656,197.461,194.981z    M197.461,272.767l-32.199,36.223c-1.586,1.785-3.795,2.7-6.02,2.7c-1.767,0-3.543-0.577-5.025-1.765l-20.125-16.099   c-3.471-2.775-4.034-7.841-1.256-11.312c2.774-3.475,7.844-4.037,11.314-1.258l14.155,11.324l27.123-30.513   c2.95-3.321,8.04-3.624,11.363-0.667C200.117,264.355,200.415,269.442,197.461,272.767z M197.461,347.156l-32.199,36.224   c-1.586,1.784-3.795,2.7-6.02,2.7c-1.767,0-3.543-0.577-5.025-1.765l-20.125-16.1c-3.471-2.774-4.034-7.841-1.256-11.312   c2.774-3.475,7.844-4.037,11.314-1.258l14.155,11.323l27.123-30.513c2.95-3.321,8.04-3.624,11.363-0.668   C200.117,338.745,200.415,343.831,197.461,347.156z M197.461,422.07l-32.199,36.224c-1.586,1.785-3.795,2.7-6.02,2.7   c-1.767,0-3.543-0.577-5.025-1.765l-20.125-16.1c-3.471-2.774-4.034-7.841-1.256-11.312c2.774-3.475,7.844-4.037,11.314-1.258   l14.155,11.323l27.123-30.513c2.95-3.321,8.04-3.624,11.363-0.668C200.117,413.659,200.415,418.746,197.461,422.07z'
                                ));
                          
                    });
                    HtmlGen::h5(array('class' => 'item-text'),'Resumen General');
                });
            });
    
                

                if (count($impuesto_predial) > 0){

                
                HtmlGen::div(array('id' => 'item1',
                                'class' => 'col-md-'.$menu,
                               'style' => 'text-align:center;height:250px;margin-bottom:10px;'), function (){
                HtmlGen::div(array('id' => 'item-1',
                                   'class' => 'div-item',
                                   'onclick' => 'openItem(event,"impuesto_predial")'), function() {
                    HtmlGen::svg(array(
                        'id' => 'svg-item-1',
                        'class' => 'svg-item',
                        'viewBox' => '0 0 27.02 27.02',
                        'style' => ''), function(){
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M3.674,24.876c0,0-0.024,0.604,0.566,0.604c0.734,0,6.811-0.008,6.811-0.008l0.01-5.581   c0,0-0.096-0.92,0.797-0.92h2.826c1.056,0,0.991,0.92,0.991,0.92l-0.012,5.563c0,0,5.762,0,6.667,0   c0.749,0,0.715-0.752,0.715-0.752V14.413l-9.396-8.358l-9.975,8.358C3.674,14.413,3.674,24.876,3.674,24.876z'
                                ));
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M0,13.635c0,0,0.847,1.561,2.694,0l11.038-9.338l10.349,9.28c2.138,1.542,2.939,0,2.939,0   L13.732,1.54L0,13.635z'
                                ));
                            HtmlGen::polygon(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'points' => '23.83,4.275 21.168,4.275 21.179,7.503 23.83,9.752'
                                ));
                    });
                    HtmlGen::h5(array('class' => 'item-text'),'Impuesto Predial');
                });
            });
            
            } 

            
            if (count($limpieza_publica) > 0){
            HtmlGen::div(array('id' => 'item2',
                               'class' => 'col-md-'.$menu,
                               'style' => 'text-align:center;height:250px;margin-bottom:10px;'), function (){
                HtmlGen::div(array('id' => 'item-2',
                                   'class' => 'div-item',
                                   'onclick' => 'openItem(event,"limpieza_publica")'), function() {
                    HtmlGen::svg(array(
                        'id' => 'svg-item-2',
                        'class' => 'svg-item',
                        'viewBox' => '0 0 520.02 520.02',
                        'style' => ''), function(){
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M328.147,139.691c-7.525-18.591-31.214-36.098-53.259-49.057c-2.593,7.931-7.59,15.159-14.828,20.473l-51.691,37.948    c-2.884,24.801,0.984,37.431,9.771,51.405h110.191C336.091,182.774,336.649,160.695,328.147,139.691z'
                                ));
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M230.117,18.656c-0.548-5.368-6.101-8.704-11.093-6.684l-18.201,7.368c-5.002,2.025-6.655,8.288-3.321,12.518    l11.225,14.243c6.984-5.127,13.281-8.73,23.212-9.595L230.117,18.656z'
                                ));
                            HtmlGen::circle(array(
                                'cx' => '92.092',
                                'cy' => '44.844',
                                'r' => '44.844'
                                ));
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M253.01,64.938c-7.074-9.633-20.615-11.71-30.249-4.638l-59.192,43.455l-70.593,9.493l12.138-4.927H64.842    c-16.732,0-30.296,13.564-30.296,30.296l-0.533,347.341c-0.041,14.342,11.552,26,25.894,26.04c0.026,0,0.049,0,0.074,0    c14.306,0,25.925-11.578,25.966-25.894l0.543-191.977c0-0.025-0.001-0.049-0.001-0.074h11.199l0.015,191.979    c0.001,14.342,11.627,25.967,25.969,25.965c14.341-0.001,25.966-11.628,25.965-25.969c-0.001-13.856-0.472-310.043-0.472-323.902    l-50.422-5.987l76.065-10.229c3.59-0.483,7.002-1.858,9.922-4.003l63.642-46.722C258.007,88.114,260.083,74.571,253.01,64.938z'
                                ));
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M468.76,54.224c-3.015-0.79-6.052-0.389-8.637,0.896l3.893-15.337c1.68-6.618-2.324-13.345-8.941-15.024    c-6.623-1.68-13.346,2.322-15.026,8.941l-48.443,190.853c-1.756,0-181.164,0-182.915,0c-6.828,0-12.363,5.535-12.363,12.363    s5.535,12.363,12.363,12.363h1.426l29.44,255.283c0.472,4.087,3.931,7.437,8.044,7.437h67.329    c-7.388-9.096-10.8-28.516-11.218-40.39c-0.629-17.882,7.954-40.321,25.512-66.694c10.36-15.562,21.815-29.425,29.211-37.909    l-13.865-42.106c-4.509-13.692,5.412-27.946,19.834-28.453c0.627-0.022,19.76-0.704,20.387-0.704c3.375,0,6.633,0.777,9.567,2.219    l5.474-48.681h1.39c5.656,0,10.591-3.839,11.983-9.321l4.777-18.819c2.389,2.631,5.721,4.05,9.145,4.05    c5.483,0,10.493-3.675,11.95-9.227l38.498-146.641C479.312,62.717,475.364,55.959,468.76,54.224z'
                                ));
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M446.713,464.677c-1.196-33.927-38-80.131-50.546-92.083l1.695-49.905c0.602-2.381,0.049-4.907-1.494-6.818    c-1.485-1.839-3.72-2.903-6.073-2.903c-0.092,0-0.183,0.001-0.275,0.004l-18.919,0.666c-5.199,0.183-8.764,5.311-7.141,10.243    l15.727,47.764c-11.675,12.804-55.665,63.382-54.47,97.312c0.336,9.542,2.275,18.586,5.504,26.789    c2.292,5.827,7.919,16.25,14.181,16.25h82.647c6.365,0,12.068-10.555,14.285-16.522    C445.323,486.082,447.099,475.635,446.713,464.677z'
                                ));


                        });
                    HtmlGen::h5(array('class' => 'item-text'),'Limpieza Pública');
                });
            });
            }


            if (count($servicio_agua) > 0){
            HtmlGen::div(array('id' => 'item3',
                               'class' => 'col-md-'.$menu,
                               'style' => 'text-align:center;height:250px;margin-bottom:10px;'), function (){
                HtmlGen::div(array('id' => 'item-3',
                                   'class' => 'div-item',
                                   'onclick' => 'openItem(event,"servicio_agua")'), function() {
                    HtmlGen::svg(array(
                        'id' => 'svg-item-3',
                        'class' => 'svg-item',
                        'viewBox' => '0 0 384.929 384.929',
                        'style' => ''), function(){
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M350.246,191.25v-66.938c0-5.259-4.303-9.562-9.562-9.562h-19.125c-5.26,0-13.865,0-19.125,0s-13.865,0-19.125,0H248.08    c-8.683-14.535-22.548-25.599-39.101-30.562c4.389-2.448,7.392-7.086,7.392-12.47c0-7.918-6.426-14.344-14.344-14.344h-4.781    V38.25h43.031c7.918,0,14.344-6.426,14.344-14.344s-6.426-14.344-14.344-14.344h-43.031c0-5.278-3.185-9.562-9.562-9.562    s-9.562,4.284-9.562,9.562h-43.031c-7.918,0-14.344,6.426-14.344,14.344s6.426,14.344,14.344,14.344h43.031v19.125h-4.781    c-7.918,0-14.344,6.426-14.344,14.344c0,5.872,3.538,10.901,8.587,13.12c-11.867,3.959-22.271,11.064-30.255,20.349H63.371V76.5    c0-10.566-8.559-19.125-19.125-19.125S25.121,65.934,25.121,76.5v143.438c0,10.566,8.559,19.125,19.125,19.125    s19.125-8.559,19.125-19.125v-38.25h65.264c11.475,21.783,34.31,36.653,60.645,36.653c33.488,0,61.315-24.031,67.301-55.778    h26.728c5.26,0,9.562,4.303,9.562,9.562v19.125c-5.26,0-9.562,4.303-9.562,9.562v19.125c0,5.26,4.303,9.562,9.562,9.562h57.375    c5.26,0,9.562-4.303,9.562-9.562v-19.125C359.808,195.553,355.505,191.25,350.246,191.25z'
                                ));
                            HtmlGen::path(array(
                                'id' => 'svg_1',
                                'fill-rule' => 'nonzero',
                                'd' => 'M279.722,344.881c0,22.118,17.93,40.048,40.048,40.048s40.038-17.93,40.038-40.048s-40.048-79.55-40.048-79.55    S279.722,322.763,279.722,344.881z'
                                ));
                    });
                    HtmlGen::h5(array('class' => 'item-text'),'Servicio de Agua');
                });
            });
        }

        });

        HtmlGen::div(array('class' => 'section default-section',
                            'id' => 'informacion_pago'), function(){
            HtmlGen::div(array('id' => 'informacion',
                                'class' => 'container'), function() {
                HtmlGen::div(array('class' => 'informacion_pago'), function(){

                    HtmlGen::div(array('class' => 'informacion-pago-content',
                                        'id' => 'resumen_general'), function() {
                       
                            echo "<div id='accordion'>";
                                global $resumen_general;
                                for($i = 0; $i < count($resumen_general); $i++ ){
                                    echo "<div class='card'>";
                                    echo "<div class='card-header'>";
                                    echo "<a class='card-link' data-toggle='collapse' href='#collapse_impuesto'".$i.">";

                                    if($resumen_general[$i]['tipo_pago'] == 1){
                                        echo "IMPUESTO PREDIAL";
                                    }

                                    if($resumen_general[$i]['tipo_pago'] == 2){
                                        echo "LIMPIEZA PUBLICA";
                                    }

                                    
                                    echo "</a>";
                                    echo "</div>";
                                    echo "<div id='collapse_impuesto'".$i." class='collapse show' data-parent='#accordion'>";
                                    echo "<div class='card-body'>";

                                    echo "<table class='table table-hover table-responsive table-light'>";
                                    echo "<tr>";
                                    echo "<th>Desde</th>";
                                    echo "<th>Hasta</th>";
                                    echo "<th>Monto</th>";
                                    echo "<th>Gasto Administrativo</th>";
                                    echo "<th>Interes</th>";
                                    echo "<th>Amnistia</th>";
                                    echo "<th>Saldo</th>";
                                    echo "</tr>";
                                    

                                    echo "<tr>";
                                    echo "<td>".$resumen_general[$i]['desde']."</td>";
                                    echo "<td>".$resumen_general[$i]['hasta']."</td>";
                                    echo "<td>".$resumen_general[$i]['monto']."</td>";
                                    echo "<td>".$resumen_general[$i]['gastoadm']."</td>";
                                    echo "<td>".$resumen_general[$i]['interes']."</td>";
                                    echo "<td>".$resumen_general[$i]['amnistia']."</td>";
                                    echo "<td>".$resumen_general[$i]['saldo']."</td>";
                                    echo "</tr>";

                                    echo "</table>";
                                    
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }           
                         echo "</div>";
                
                    });

                    HtmlGen::div(array('class' => 'informacion-pago-content',
                                        'id' => 'impuesto_predial'), function() {
                       
                            echo "<div id='accordion'>";
                                global $impuesto_predial;
                                global $periodo_anterior;
                                for($i = 0; $i < count($impuesto_predial); $i++ ){

                                    $anio = substr($impuesto_predial[$i]['fecha_vencimiento'], 0, 4);
                                    if ($periodo_anterior == ""){
                                    echo "<div class='card'>";
                                    echo "<div class='card-header'>";
                                    echo "<a class='card-link' data-toggle='collapse' href='#collapse_impuesto'".$i.">";
                                    echo $anio;
                                    echo "</a>";
                                    echo "</div>";
                                    echo "<div id='collapse_impuesto'".$i." class='collapse show' data-parent='#accordion'>";
                                    echo "<div class='card-body'>";
                                    $periodo_anterior = $anio;

                                    echo "<table class='table table-hover table-responsive table-light'>";
                                    echo "<tr>";
                                    echo "<th>Base</th>";
                                    echo "<th>Monto</th>";
                                    echo "<th>Gasto Administrativo</th>";
                                    echo "<th>Intereses</th>";
                                    echo "<th>Intereses al Fraccionar</th>";
                                    echo "<th>Amnistía</th>";
                                    echo "<th>SubTotal</th>";
                                    echo "<th>Fecha de Vencimiento</th>";
                                    echo "<th>Estado</th>";
                                    echo "<th>Fecha de Cancelación</th>";
                                    echo "</tr>";
                                    
                                    if($impuesto_predial[$i]['estado'] == 'P'){
                                        echo "<tr style= 'background-color:pink;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'C'){
                                        echo "<tr style= 'background-color:mediumseagreen;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'A'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'F'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    echo "<td>".$impuesto_predial[$i]['base']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['monto']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['gastoadm']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['interes']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['interes_fraccionar']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['amnistia']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['subtotal']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['fecha_vencimiento']."</td>";
                                    if($impuesto_predial[$i]['estado'] == 'P'){
                                        echo "<td>PENDIENTE</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'C'){
                                        echo "<td>CANCELADA</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'A'){
                                        echo "<td>COACTIVA</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'F'){
                                        echo "<td>FRACCIONADA</td>";
                                    }

                                    if($impuesto_predial[$i]['fecha'] != '0000-00-00'){
                                        echo "<td>".$impuesto_predial[$i]['fecha']."</td>";
                                    }
                                    else{echo "<td></td>";}
                                    
                                    echo "</tr>";

                                    echo "</table>";

                                }else{
                                    if ($periodo_anterior == $anio){

                                   echo "<table class='table table-hover table-responsive table-light'>";
                                    echo "<tr>";
                                    echo "<th>Base</th>";
                                    echo "<th>Monto</th>";
                                    echo "<th>Gasto Administrativo</th>";
                                    echo "<th>Intereses</th>";
                                    echo "<th>Intereses al Fraccionar</th>";
                                    echo "<th>Amnistía</th>";
                                    echo "<th>SubTotal</th>";
                                    echo "<th>Fecha de Vencimiento</th>";
                                    echo "<th>Estado</th>";
                                    echo "<th>Fecha de Cancelación</th>";
                                    echo "</tr>";
                                    
                                    if($impuesto_predial[$i]['estado'] == 'P'){
                                        echo "<tr style= 'background-color:pink;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'C'){
                                        echo "<tr style= 'background-color:mediumseagreen;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'A'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'F'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    echo "<td>".$impuesto_predial[$i]['base']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['monto']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['gastoadm']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['interes']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['interes_fraccionar']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['amnistia']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['subtotal']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['fecha_vencimiento']."</td>";
                                    if($impuesto_predial[$i]['estado'] == 'P'){
                                        echo "<td>PENDIENTE</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'C'){
                                        echo "<td>CANCELADA</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'A'){
                                        echo "<td>COACTIVA</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'F'){
                                        echo "<td>FRACCIONADA</td>";
                                    }

                                    if($impuesto_predial[$i]['fecha'] != '0000-00-00'){
                                        echo "<td>".$impuesto_predial[$i]['fecha']."</td>";
                                    }
                                    else{echo "<td></td>";}
                                    
                                    echo "</tr>";

                                    echo "</table>";
                                }
                                else{
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "<div class='card'>";
                                    echo "<div class='card-header'>";
                                    echo "<a class='card-link' data-toggle='collapse' href='#collapse_impuesto'".$i.">";
                                    echo $anio;
                                    echo "</a>";
                                    echo "</div>";
                                    echo "<div id='collapse_impuesto'".$i." class='collapse show' data-parent='#accordion'>";
                                    echo "<div class='card-body'>";
                                    $periodo_anterior = $anio;

                                    echo "<table class='table table-hover table-responsive table-light'>";
                                    echo "<tr>";
                                    echo "<th>Base</th>";
                                    echo "<th>Monto</th>";
                                    echo "<th>Gasto Administrativo</th>";
                                    echo "<th>Intereses</th>";
                                    echo "<th>Intereses al Fraccionar</th>";
                                    echo "<th>Amnistía</th>";
                                    echo "<th>SubTotal</th>";
                                    echo "<th>Fecha de Vencimiento</th>";
                                    echo "<th>Estado</th>";
                                    echo "<th>Fecha de Cancelación</th>";
                                    echo "</tr>";
                                    
                                    if($impuesto_predial[$i]['estado'] == 'P'){
                                        echo "<tr style= 'background-color:pink;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'C'){
                                        echo "<tr style= 'background-color:mediumseagreen;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'A'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'F'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    echo "<td>".$impuesto_predial[$i]['base']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['monto']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['gastoadm']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['interes']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['interes_fraccionar']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['amnistia']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['subtotal']."</td>";
                                    echo "<td>".$impuesto_predial[$i]['fecha_vencimiento']."</td>";
                                    if($impuesto_predial[$i]['estado'] == 'P'){
                                        echo "<td>PENDIENTE</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'C'){
                                        echo "<td>CANCELADA</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'A'){
                                        echo "<td>COACTIVA</td>";
                                    }
                                    if($impuesto_predial[$i]['estado'] == 'F'){
                                        echo "<td>FRACCIONADA</td>";
                                    }

                                    if($impuesto_predial[$i]['fecha'] != '0000-00-00'){
                                        echo "<td>".$impuesto_predial[$i]['fecha']."</td>";
                                    }
                                    else{echo "<td></td>";}
                                    
                                    echo "</tr>";

                                    echo "</table>";


                                }
                            }
                                 

                        }

                                    
                            echo "</div>";
                             echo "</div>";
                            echo "</div>";
           
                            echo "</div>";


                                    
                                    
                
                    });
                    HtmlGen::div(array('class' => 'informacion-pago-content',
                                        'id' => 'limpieza_publica'), function() {
                       
                                echo "<div id='accordion'>";
                                global $limpieza_publica;
                                for($i = 0; $i < count($limpieza_publica); $i++ ){
                                    echo "<div class='card'>";
                                    echo "<div class='card-header'>";
                                    echo "<a class='card-link' data-toggle='collapse' href='#collapse_impuesto'".$i.">";
                                    echo $limpieza_publica[$i]['periodo'];
                                    echo "</a>";
                                    echo "</div>";
                                    echo "<div id='collapse_impuesto'".$i." class='collapse show' data-parent='#accordion'>";
                                    echo "<div class='card-body'>";

                                 
			            echo "<table class='table table-hover table-responsive table-light'>";
                                    echo "<tr>";
                                    echo "<th>Periodos</th>";
                                    echo "<th>Monto</th>";
                                    echo "<th>Gasto Administrativo</th>";
                                    echo "<th>Intereses</th>";
                                    echo "<th>Intereses al Fraccionar</th>";
                                    echo "<th>Amnistía</th>";
                                    echo "<th>SubTotal</th>";
                                    echo "<th>Fecha de Vencimiento</th>";
                                    echo "<th>Estado</th>";
                                    echo "<th>Fecha de Cancelación</th>";
                                    echo "</tr>";

                                    if($limpieza_publica[$i]['estado'] == 'P'){
                                        echo "<tr style= 'background-color:pink;'>";
                                    }
                                    if($limpieza_publica[$i]['estado'] == 'C'){
                                        echo "<tr style= 'background-color:mediumseagreen;'>";
                                    }
                                    if($limpieza_publica[$i]['estado'] == 'A'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    if($limpieza_publica[$i]['estado'] == 'F'){
                                        echo "<tr style= 'background-color:lightyellow;'>";
                                    }
                                    echo "<td>".$limpieza_publica[$i]['base']."</td>";
                                    echo "<td>".$limpieza_publica[$i]['monto']."</td>";
                                    echo "<td>".$limpieza_publica[$i]['gastoadm']."</td>";
                                    echo "<td>".$limpieza_publica[$i]['interes']."</td>";
                                    echo "<td>".$limpieza_publica[$i]['interes_fraccionar']."</td>";
                                    echo "<td>".$limpieza_publica[$i]['amnistia']."</td>";
                                    echo "<td>".$limpieza_publica[$i]['subtotal']."</td>";
                                    echo "<td>".$limpieza_publica[$i]['fecha_vencimiento']."</td>";
                                    if($limpieza_publica[$i]['estado'] == 'P'){
                                        echo "<td>PENDIENTE</td>";
                                    }
                                    if($limpieza_publica[$i]['estado'] == 'C'){
                                        echo "<td>CANCELADA</td>";
                                    }
                                    if($limpieza_publica[$i]['estado'] == 'A'){
                                        echo "<td>COACTIVA</td>";
                                    }
                                    if($limpieza_publica[$i]['estado'] == 'F'){
                                        echo "<td>FRACCIONADA</td>";
                                    }
                                    if($limpieza_publica[$i]['fecha'] != '0000-00-00'){
                                        echo "<td>".$limpieza_publica[$i]['fecha']."</td>";
                                    }
                                    else{echo "<td></td>";}
                                    echo "</tr>";

                                    echo "</table>";
                                    
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }           
                         echo "</div>";
                                
                                  




                    });
                    HtmlGen::div(array('class' => 'informacion-pago-content',
                                        'id' => 'servicio_agua'), function() {
                        
                            echo "<div id='accordion'>";
                                global $servicio_agua;
                                for($i = 0; $i < count($servicio_agua); $i++ ){
                                    echo "<div class='card'>";
                                    echo "<div class='card-header'>";
                                    echo "<a class='card-link' data-toggle='collapse' href='#collapse'".$i.">";
                                    echo $servicio_agua[$i][3];
                                    echo "</a>";
                                    echo "</div>";
                                    echo "<div id='collapse'".$i." class='collapse show' data-parent='#accordion'>";
                                    echo "<div class='card-body'>";
                                   
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }           
                         echo "</div>";



                    });
                });
            });

        });

    });

    HtmlGen::div(array('id' => 'footer','class' => 'footer'),function () {
        HtmlGen::h6(array('class' => 'footer-detail'), 'Copyright. © Derechos reservados.');
        HtmlGen::h6(array('class' => 'footer-detail'), 'Centro Guamán Poma de Ayala - 2019');
    });





   ?>



<style>
 

    /* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 11px 17px;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>










        <script>
        function openMonth(evt, cityName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
        }
        </script>



        <script>
        function openItem(evt, item) {
          var i, tabcontent, tablinks;
          var dock = init;
          tabcontent = document.getElementsByClassName("informacion-pago-content");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.opacity = "0";
            tabcontent[i].style.height = "0";
            tabcontent[i].style.overflow = "hidden";
          }
          tablinks = document.getElementsByClassName("div-item");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          if (dock == 0){
            var element = document.getElementById("item-0");
            element.className += " active";
            init = 1;
          }
          document.getElementById(item).style.height = "auto";
          document.getElementById(item).style.opacity = "1";
          evt.currentTarget.className += " active";
        }
        </script>

    
   
        <script>
          var init = 0;
          openItem(event,'resumen_general');
          openMonth(event,'enero');
        </script>

    


        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/1.7.4/jquery.dotdotdot.min.js"></script>
        <script src="../scripts/lightbox.min.js"></script>
        <script src="../scripts/bootstrap-tabcollapse.js"></script>
        <script src="../scripts/functions.js"></script>
        <script src="../scripts/home.js"></script>
        <script src="../scripts/slider/js/ism-2.2.min.js"></script>
        
        <!-- Scripts -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/1.7.4/jquery.dotdotdot.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


        
        
        


        

    </body>
</html>
