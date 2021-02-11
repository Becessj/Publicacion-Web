<?php
    // Controlador de base de datos

    // En este archivo se definen las funciones
    // que permiten la comunicación con la base
    // de datos y la ejecución de sus rutinas.

    // Comprueba si el archivo fue cargado directamente desde el navegador
    

    // Construye el nombre del origen de datos
    if (defined('DATABASE_HOST') and defined('DATABASE_NAME')) {
        $dsn = 'mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME;
    }

    // Recupera el nombre de usuario de la base de datos
    if (defined('DATABASE_USER')) {
        $user = DATABASE_USER;
    }

    // Recupera la contraseña del usuario de la base de datos
    if (defined('DATABASE_PASSWORD')) {
        $password = DATABASE_PASSWORD;
    }

    // Valida los parámetros de conexión
    if (isset($dsn, $user, $password)) {
        // Intenta establecer conexión con la base de datos
        try {
            $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        }
        catch (PDOException $e) {
            // Error en la conexión
            echo $e->getMessage();
            exit;
        }
    }
    else {
        // Error al recuperar los parámetros de conexión
        echo utf8_decode('Uno o más parámetros de conexión no han sido definidos.');
        exit;
    }

    function verificar_credenciales ($nombre_usuario, $contrasena) {
        global $dbh;
        $query = 'call VerificarCredenciales(?, ?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(2, $contrasena, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result == 1;
    }

    function verificar_administrador ($nombre_usuario, $contrasena) {
        global $dbh;
        $query = 'call VerificarAdministrador(?, ?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(2, $contrasena, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result == 1;
    }


    function token_sesion_usuario ($nombre_usuario) {
        global $dbh;
        $query = 'call TokenSesionUsuario(?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $nombre_usuario, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    function rol_usuario ($token_sesion) {
        global $dbh;
        $query = 'call RolUsuario(?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $token_sesion, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    function cuentas_administrables () {
        global $dbh;
        $query = 'select * from CuentasAdministrables';
        $stmt = $dbh->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function verificar_nombre_usuario ($nombre_usuario) {
        global $dbh;
        $query = 'call VerificarNombreUsuario(?)';
        $stmt = $dbh-> prepare($query);
        $stmt->bindParam(1, $nombre_usuario, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    function datos_usuario ($id) {
        global $dbh;
        $query = 'call DatosUsuario(?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function crear_cuenta_usuario ($nombre_usuario) {
        global $dbh;
        $query = 'call CrearCuentaUsuario(?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $nombre_usuario, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    function restablecer_contrasena ($id) {
        global $dbh;
        $query = 'call RestablecerContrasena(?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    function eliminar_cuenta_usuario ($id) {
        global $dbh;
        $query = 'call EliminarCuentaUsuario(?)';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    function configuracion_pagina () {
        global $dbh;
        $query = 'select * from configuracion_pagina';
        $stmt = $dbh->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function contribuyente ($contribuyente) {
        global $dbh;
        $query = "select * from contribuyente where persona = '".$contribuyente."';";
        $stmt = $dbh->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function municipalidades () {
        global $dbh;
        $query = 'select * from municipalidades';
        $stmt = $dbh->query($query);
        $result = $stmt->fetchAll();
        return $result;
    }

    function municipalidad_seleccionada () {
        global $dbh;
        $query = 'select * from municipalidad_seleccionada';
        $stmt = $dbh->query($query);
        $result = $stmt->fetchColumn();
        return $result;
    }

    function cambiarmunicipalidad ($municipalidad){
        global $dbh;
        $query = 'call CambiarMunicipalidad('.$municipalidad.')';
        $stmt = $dbh->query($query);
        $result = $stmt->fetchColumn();
        return $result;
    }

    function impuesto_predial ($clave) {
        global $dbh;
        $query = 'call ImpuestoPredial("'.$clave.'")';
        $stmt = $dbh->query($query);
        $result = $stmt->fetchAll();
        return $result;
    }

    function limpieza_publica ($clave) {
        global $dbh;
        $query = 'call LimpiezaPublica("'.$clave.'")';
        $stmt = $dbh->query($query);
        $result = $stmt->fetchAll();
        return $result;
    
    }

    function resumen_general($clave){
        global $dbh;
        $query = 'call ResumenGeneral("'.$clave.'")';
        $stmt = $dbh->query($query);
        $result = $stmt->fetchAll();
        return $result;
    }

    function servicio_agua ($clave) {
        global $dbh;
        $query = 'call ServicioAgua("'.$clave.'")';
        $stmt = $dbh->query($query);
	if ($result != FALSE) {
        	$result = $stmt->fetchAll();
	}else{}
        return $result;

    }


?>