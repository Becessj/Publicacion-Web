<?php
    // Archivo controlador de sesiones

    // Este archivo contiene las funciones que
    // permiten manejar las sesiones de los
    // usuarios del sistema.
	
    function iniciar_sesion_cpanel($token,$nombre_usuario) {
        $_SESSION['SESSION_TOKEN'] = $token;
        $_SESSION['user_id'] = $nombre_usuario;
   
    }

    function iniciar_sesion_user($token,$nombre_usuario) {
        $_SESSION['SESSION_TOKEN'] = $token;
        $_SESSION['user_id'] = $nombre_usuario;
   
    }
    
    function sesion_activa_cpanel() {
	if($_SESSION['SESSION_TOKEN'] == 'cpanel') {
		return True;
	}
	else{
		return False;
		}
        //return isset($_SESSION['SESSION_TOKEN']) ? $_SESSION['SESSION_TOKEN'] : FALSE;
    }

    function sesion_activa_user() {
        return isset($_SESSION['SESSION_TOKEN']) ? $_SESSION['SESSION_TOKEN'] : FALSE;
    }

    function cerrar_sesion() {
        $_SESSION = array();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 300, '/');
            session_destroy();
        }
    }
?>