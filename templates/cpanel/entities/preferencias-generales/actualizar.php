<?php
require_once('system.php');
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '0');


$municipalidad = $_POST['municipalidades'];
$colorprimario = $_POST['colorprimario'];
$colorsecundario = $_POST['colorsecundario'];
$colorbase = $_POST['colorbase'];



if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

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

    function update($municipalidad,$colorprimario,$colorsecundario,$colorbase) {
        




        $query = "update configuracion set nombre_municipalidad = ".$municipalidad.
                                        ", colorprimario = ".$colorprimario.
                                        ",colorsecundario = ".$colorsecundario.
                                        ",colorbase = ".$colorbase.";" 

                                                
        echo $query;
        $stmt = $dbh->query($query);

        

    }



//Loop through the CSV rows.
while (($row = fgetcsv($fileHandle, 0, ";")) !== FALSE) {
    //Dump out the row for the sake of clarity.
    insertar($row);
}

?>