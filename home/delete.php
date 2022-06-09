<?php
require_once('system.php');
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '0');



 

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

   


    function borrar() {
        global $dbh;
        
        $query = "delete from cuentas; ";
        $stmt = $dbh->query($query);
        echo $query;
       
    }
    function borrarc() {
        global $dbh;
        
        $query = "delete from contribuyente; ";
        $stmt = $dbh->query($query);
        echo $query;
       
    }
    
    



borrar();
borrarc();




?>