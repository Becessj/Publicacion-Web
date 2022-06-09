<?php
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$persona = "";
$clave = "";
$nombre = "";
$direccion = "";
$token = "";

$persona_err = "";
$clave_err = "";
$nombre_err = "";
$direccion_err = "";
$token_err = "";


// Processing form data when form is submitted
if(isset($_POST["persona"]) && !empty($_POST["persona"])){
    // Get hidden input value
    $persona = $_POST["persona"];

    // Prepare an update statement
    $dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    try {
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('Something weird happened');
    }

    $vars = parse_columns('contribuyente', $_POST);
    $stmt = $pdo->prepare("UPDATE contribuyente SET persona=?,clave=?,nombre=?,direccion=?,token=? WHERE persona=?");

    if(!$stmt->execute([ $persona,$clave,$nombre,$direccion,$token,$persona  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } 
} else {
    // Check existence of id parameter before processing further
	$_GET["persona"] = trim($_GET["persona"]);
    if(isset($_GET["persona"]) && !empty($_GET["persona"])){
        // Get URL parameter
        $persona =  trim($_GET["persona"]);

        // Prepare a select statement
        $sql = "SELECT * FROM contribuyente WHERE persona = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $persona;

            // Bind variables to the prepared statement as parameters
			if (is_int($param_id)) $__vartype = "i";
			elseif (is_string($param_id)) $__vartype = "s";
			elseif (is_numeric($param_id)) $__vartype = "d";
			else $__vartype = "b"; // blob
			mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value

                    $persona = $row["persona"];
					$clave = $row["clave"];
					$nombre = $row["nombre"];
					$direccion = $row["direccion"];
					$token = $row["token"];
					

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.<br>".$stmt->error;
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ACTUALIZAR CONTRIBUYENTE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>ACTUALIZAR CONTRIBUYENTE</h2>
                    </div>
                    <p></p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                                <label>PERSONA</label>
                                <input type="text" name="persona" readonly maxlength="20"class="form-control" value="<?php echo $persona; ?>">
                                <span class="form-text"><?php echo $persona_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>CLAVE</label>
                                <input type="text" name="clave" readonly maxlength="20"class="form-control" value="<?php echo $clave; ?>">
                                <span class="form-text"><?php echo $clave_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>NOMBRE</label>
                                <textarea name="nombre" readonly class="form-control"><?php echo $nombre ; ?></textarea>
                                <span class="form-text"><?php echo $nombre_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>DIRECCION</label>
                                <textarea name="direccion" readonly class="form-control"><?php echo $direccion ; ?></textarea>
                                <span class="form-text"><?php echo $direccion_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>TOKEN</label>
                                <input type="text" name="token" readonly maxlength="50"class="form-control" value="<?php echo $token; ?>">
                                <span class="form-text"><?php echo $token_err; ?></span>
                            </div>
                        <?php
                        echo '<input type="submit" class="btn btn-primary" value="ACCEDER1" href="http://munisansebastian.gob.pe/publicacion/home/inicio.php?nombre-usuario='.$row["persona"].'&contrasena='.$row["clave"].'">';
                        ?>
                        <input type="hidden" name="persona" value="<?php echo $persona; ?>"/>
                        <input type="submit" class="btn btn-primary" value="ACCEDER" href="http://munisansebastian.gob.pe/publicacion/home/inicio.php?nombre-usuario="<?php echo $persona."&contrasena=".$clave;?>>
                        <a href="contribuyente-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
