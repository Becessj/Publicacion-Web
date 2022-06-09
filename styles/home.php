<?php
    // Inicializa los recursos del sistema
    require_once('system.php');
    
    // Define la cabecera para una hoja de estilos en cascada
    header('Content-type: text/css');

    // Recupera el tema actual y sus componentes


    $configuracion = configuracion_pagina();
  
    $url_logo = BASE_URL.'/publicacion/images/backgroundcalca.jpg';

    $login_logo = BASE_URL.'/publicacion/images/pumacalca.jpg';

    $background = BASE_URL.'/publicacion/images/background.jpg';

function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
   
    // Construye la ruta del archivo correspondiente a la imagen de logotipo de cabecera
    //$archivo_logo = join_paths(STORAGE_PATH, 'entidad', 'header-logo.png');

    // Verifica si no existe el archivo en la ruta obtenida

    /*
    if (!file_exists($archivo_logo)) {
        // Obtiene el URL de la imagen alternativa de contingencia
        $url_logo = '../images/header-logo-placeholder.png';
    }
    else {
        // Obtiene el URL de la imagen
        $url_logo =  '../storage/entidad/header-logo.png';
    }

    // Construye la ruta del archivo correspondiente a la imagen de fondo
    $archivo_fondo = join_paths(STORAGE_PATH, 'entidad', 'background.jpg');

    // Verifica si no existe el archivo en la ruta obtenida
    if (!file_exists($archivo_fondo)) {
        // Obtiene el URL de la imagen alternativa de contingencia
        $url_fondo = '../images/background-placeholder.jpg';
    }
    else {
        // Obtiene el URL de la imagen
        $url_fondo =  '../storage/entidad/background.jpg';
    }

    // Construye la ruta del archivo correspondiente a la imagen de fondo alternativa
    $archivo_fondo_alt = join_paths(STORAGE_PATH, 'entidad', 'background-alt.jpg');

    // Verifica si no existe el archivo en la ruta obtenida
    if (!file_exists($archivo_fondo_alt)) {
        // Obtiene el URL de la imagen alternativa de contingencia
        $url_fondo_alt = '../images/background-alt-placeholder.jpg';
    }
    else {
        // Obtiene el URL de la imagen
        $url_fondo_alt = '../storage/entidad/background-alt.jpg';
    }
    */
?>


@font-face {
  font-family: Open-Sans-Light;
  src: url('../fonts/cicle/OpenSans-Light.ttf');
}

@font-face {
  font-family: Italianno;
  src: url('../fonts/italianno/Italianno-Regular.ttf');
}

@font-face {
  font-family: Calibri-Light;
  src: url('../fonts/calibrilight/calibril.woff');
}

@font-face {
  font-family: Catamaran;
  src: url('../fonts/catamaran/Catamaran-Thin.ttf');
}

body{
    font-family: 'Calibri-Light';
    background-image: <?php echo "url(".$url_logo.");"; ?>;
    height:100%;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
}

.bg-login.none{

    background-image: <?php echo "url(".$background.");"; ?>;
}

#form-login{
    margin-top:5cm;
}

.container.bg-default.login-menu{
    margin-top: 2cm;
    font-family: 'Calibri-Light';
    background-image: <?php echo "url(".$login_logo.");"; ?>;
    height:100%;
    background-repeat: no-repeat;
    width:510px;
    height:592px;
}

label.control-label{
color:white;
text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}

button.btn.btn-primary{
     background-color: <?php echo $configuracion['colorprimario']; ?>;


}

.table{
    font-size:11px;
}

.svg-item{
    height: 100px;
    text-align: center;
    width:40%;
    margin-top:3em;
    fill: #ffffff;  
}

.div-item h5{
    color: #ffffff;
}


.item-text{
    margin-top: -0.1px;
}

.page-header{
    font-family: 'Calibri-Light';
    text-align: center;
    background-color: <?php echo hex_to_rgba($configuracion['colorprimario'], 0.7); ?>;
    padding: 20px;
    color:#ffffff;
    border-bottom:none;
}

.page-header a{
    text-decoration: none;
    color: white;
}

.div-item{
    font-family: 'Calibri-Light';
    width:200px;
    height:200px;
    text-align:center;
    vertical-align:middle;
    background-color:rgba(0, 0, 0, 0.5);
    margin:auto;

}

.footer{
    position:absolute;
    background-color: #333333;
    left: 0;
    bottom: 0;
    width: 100%;
    color: white;
    text-align: center;
    padding:20px;
    margin-top:2cm;
    bottom:auto;
}


.card{
    background-color:rgba(0, 0, 0, 0.5) !important;
}

.card-header{
    font-family: 'Calibri-Light';
    background-color: <?php echo hex_to_rgba($configuracion['colorprimario'], 0.7); ?>  !important;
    color: #000000;
}

.card-header a{
    font-family: 'Catamaran';
    color: #ffffff;
    font-weight: bold;
}

a#cerrarsesion{
    padding: 10px 30px;   
}

.logout{
    float:right;
    margin-right:1em;
    padding:10px 20px;
    background-color:rgba(255, 255, 255, 0.5) !important;
}

.logo-entidad{
    position: absolute;
    margin-top: -1cm;
    float: left;
    margin-left: -5cm;

}


.active >svg {
    fill:<?php echo $configuracion['colorprimario']; ?>;
    transform: scale(1.1);
}

.active >h5 {
    color:<?php echo $configuracion['colorprimario']; ?>;
    transform: scale(1.1);
}

#item0 :hover #svg-item-0{
    transform: scale(1.1);
    fill: <?php echo $configuracion['colorprimario']; ?>;
}

#item0 :hover h5{
    transform: scale(1.1);
    color: <?php echo $configuracion['colorprimario']; ?>;
}

#item1 :hover #svg-item-1{
    transform: scale(1.1);
    fill: <?php echo $configuracion['colorprimario']; ?>;
}

#item1 :hover h5{
    transform: scale(1.1);
    color: <?php echo $configuracion['colorprimario']; ?>;
}

#item2 :hover #svg-item-2{
    transform: scale(1.1);
    fill: <?php echo $configuracion['colorprimario']; ?>;
}

#item2 :hover h5{
    transform: scale(1.1);
    color: <?php echo $configuracion['colorprimario']; ?>;
}

#item3 :hover #svg-item-3{
    transform: scale(1.1);
    fill: <?php echo $configuracion['colorprimario']; ?>;
}

#item3 :hover h5{
    transform: scale(1.1);
    color: <?php echo $configuracion['colorprimario']; ?>;
}


.item-text{
    margin-top:10px;
}

.default-section{
    margin-bottom:2cm;  
}

#vacio{
    background-color:#ffffff;
}

.div_informacion{
    font-family: 'Calibri-Light';
    margin-auto;
    background-color:rgba(0, 0, 0, 0.5);
    padding: 20px;
    margin: 70px auto;
    color: #ffffff;
    animation: SlideInLeft ease 1s; 
    animation-iteration-count: 1; 
    animation-fill-mode: forwards; 

}

@media screen and (min-width: 768px){
    .table-responsive{
    display:inline-table !important;
    }
}

@media screen and (max-width: 518px){
    .container.bg-default.login-menu{
   
    width:100%;
    }
}

@media screen and (max-width: 720px){
    .logo-entidad{
    	width:60px;
    	height:60px;
	display:none;
    }

}

@media screen and (max-width: 460px){
    .logo-entidad{
    	width:60px;
    	height:60px;
        display:none;
    }


}

#item0{
            animation: SlideInDown ease 1s; 
            animation-iteration-count: 1; 
            animation-fill-mode: forwards; 
}

#item1{
            animation: SlideInUp ease 1s; 
            animation-iteration-count: 1; 
            animation-fill-mode: forwards; 
}

#item2{
            animation: SlideInDown ease 1s; 
            animation-iteration-count: 1; 
            animation-fill-mode: forwards; 
}

#item3{
            animation: SlideInUp ease 1s; 
            animation-iteration-count: 1; 
            animation-fill-mode: forwards; 
}

#informacion{
            animation: SlideInRight ease 1s; 
            animation-iteration-count: 1; 
            animation-fill-mode: forwards; 
}

@keyframes SlideInUp { 
from {
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0);
    visibility: visible;
  }

  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
} 

@keyframes SlideInDown { 
from {
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
    visibility: visible;
  }

  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
} 

@keyframes SlideInLeft { 
from {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
    visibility: visible;
  }

  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
} 

@keyframes SlideInRight{ 
  from {
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0);
    visibility: visible;
  }

  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
} 