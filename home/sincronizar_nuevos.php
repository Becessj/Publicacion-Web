<?php
require_once('system.php');
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '0');


$insertar = fopen("../uploads/insertar.csv", "r");
$actualizar = fopen("../uploads/actualizar.csv", "r");
$borrar = fopen("../uploads/borrar.csv", "r");

 

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

    function insertar($fila) {
        global $dbh;
        $tipo_pago = 0;
        $estado = 'C';

        $persona = "'".$fila[0]."'";
        $clave = "'".$fila[1]."'";
        $nombre = "'".$fila[2]."'";
        $direccion = "'".$fila[3]."'";

        if($fila[4] == 'IMPUESTO PREDIAL'){
            $tipo_pago = 1;
        }
        if($fila[4] == 'LIMPIEZA PUBLICA'){
            $tipo_pago = 2;
        }

        $periodo = "'".$fila[5]."'";
        $base = "'".$fila[6]."'";
        $monto = $fila[7];
        $gastoadm = $fila[8];
        $interes = $fila[9];
        $interes_fraccionar = $fila[10];
        $amnistia = $fila[11];
        $subtotal = $fila[12];
  

        if($fila[14] == 'CANCELADO'){
            $estado = 'C';

        }
        if($fila[14] == 'PENDIENTE'){
            $estado = 'P';
        }
        if($fila[14] == 'FRACCIONADA'){
            $estado = 'F';
        }
        if($fila[14] == 'COACTIVA'){
            $estado = 'A';
        }
   
     

        if(!is_null($fila[16])){
            $tipo_doc = 1;
        }else{$tipo_doc = 0;}

        
        $numero = "'".$fila[17]."'";
        $anio = $fila[18];
        $nrocuenta = "'".$fila[19]."'";




        $query = "insert into cuentas values (".$persona.","
                                                .$clave.","
                                                .$nombre.","
                                                .$direccion.","
                                                .$tipo_pago.","
                                                .$periodo.","
                                                .$base.","
                                                .$monto.","
                                                .$gastoadm.","
                                                .$interes.","
                                                .$interes_fraccionar.","
                                                .$amnistia.","
                                                .$subtotal.",'"
                                                .$fila[13]."','"
                                                .$estado."','"
                                                .$fila[15]."',"
                                                .$tipo_doc.","
                                                .$numero.","
                                                .$anio.","
                                                .$nrocuenta.");";

        if($persona != ""){
        	echo $query;
        	$queryexists = "select * from cuentas where persona = ".$persona." and tipo_pago = ".$tipo_pago." and periodo = ".$periodo.";";
        	$result =$dbh->query($queryexists);
        	if ($result->num_rows == 0) {
                $stmt = $dbh->query($query);
                printf("Registros insertados: %d\n", mysqli_affected_rows());
            }
        }

        

    }

    function actualizar($fila) {
        global $dbh;
        $tipo_pago = 0;
        $estado = 'C';

        $persona = "'".$fila[0]."'";
        $clave = "'".$fila[1]."'";
        $nombre = "'".$fila[2]."'";
        $direccion = "'".$fila[3]."'";

        if($fila[4] == 'IMPUESTO PREDIAL'){
            $tipo_pago = 1;
        }
        if($fila[4] == 'LIMPIEZA PUBLICA'){
            $tipo_pago = 2;
        }

        $periodo = "'".$fila[5]."'";
        $base = "'".$fila[6]."'";
        $monto = $fila[7];
        $gastoadm = $fila[8];
        $interes = $fila[9];
        $interes_fraccionar = $fila[10];
        $amnistia = $fila[11];
        $subtotal = $fila[12];
  

        if($fila[14] == 'CANCELADO'){
            $estado = 'C';

        }
        if($fila[14] == 'PENDIENTE'){
            $estado = 'P';
        }
        if($fila[14] == 'FRACCIONADA'){
            $estado = 'F';
        }
        if($fila[14] == 'COACTIVA'){
            $estado = 'A';
        }
   
     

        if(!is_null($fila[16])){
            $tipo_doc = 1;
        }else{$tipo_doc = 0;}

        
        $numero = "'".$fila[17]."'";
        $anio = $fila[18];
        $nrocuenta = "'".$fila[19]."'";




        $query = "update cuentas set clave = ".$clave.",".
                                     "nombre = ".$nombre.",".
                                  "direccion = ".$direccion.",".
                                       "base = ".$base.",".
                                      "monto = ".$monto.",".
                                   "gastoadm = ".$gastoadm.",".
                                    "interes = ".$interes.",".
                         "interes_fraccionar = ".$interes_fraccionar.",".
                                   "amnisita = ".$amnistia.",".
                                   "subtotal = ".$subtotal.",".
                          "fecha_vencimiento = '".$fila[13]."',".
                                     "estado = '".$estado."',".
                                      "fecha = '".$fila[15]."',".
                                   "tipo_doc = ".$tipo_doc.",".
                                     "numero = ".$numero.",".
                                       "anio = ".$anio." where persona = ".$persona." and ".
                                  								   "tipo_pago = ".$tipo_pago." and ".
                                  								   "periodo = ".$periodo." and ".
                                                                   "nrocuenta = ".$nrocuenta.";";

        if($persona != ""){
        	$stmt = $dbh->query($query);
        	echo $query;
        	printf("Registros actualizados: %d\n", mysqli_affected_rows());
        }

    }


    function borrar($fila) {
        global $dbh;
        $nrocuenta = "'".$fila[0]."'";
        $query = "delete from cuentas where nrocuenta = ".$nrocuenta.";";
        $stmt = $dbh->query($query);
        echo $query;
        printf("Registros borrados: %d\n", mysqli_affected_rows());
    }
 
    function contribuyente_nuevo(){
        global $dbh;
        $query = "insert into contribuyente select persona,clave,nombre,direccion,persona from cuentas where persona not in ( SELECT persona FROM `contribuyente` ) group by persona,clave,nombre,direccion";
        $stmt = $dbh->query($query);
        echo $query;
        printf("Registros insertados en contribuyente: %d\n", mysqli_affected_rows());
    }
    

$myfile = fopen('date.ini','w');
$txt = date("Y-m-d");
fwrite($myfile, $txt);

fclose($myfile);

while (($row = fgetcsv($borrar, 0, ";")) !== FALSE) {
    //Dump out the row for the sake of clarity.
    borrar($row);

}
//Loop through the CSV rows.
while (($row = fgetcsv($insertar, 0, ";")) !== FALSE) {
    insertar($row);
}

while (($row = fgetcsv($actualizar, 0, ";")) !== FALSE) {
	actualizar($row);
}

contribuyente_nuevo();



?>