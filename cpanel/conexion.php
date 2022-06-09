<?php
/*Datos de conexion a la base de datos*/
$db_host = "localhost";
$db_user = "exviskcj_publicacion";
$db_pass = "aYR8J^MI^yn#";
$db_name = "exviskcj_publicacion";

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno()){
    echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error();
}
?>