<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MANTENIMIENTOS APP</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">

                <?php

                if (!file_exists("Config.php")) {

                    echo "<div class='alert alert-warning' role='alert'>
                    DEBE CREAR ARCHIVO DE CONFIGURACIÓN <strong>'Config.php'</strong>
                </div>";

                    return;
                }

                require_once "Config.php";
                require_once "System/Conexion.php";
                require_once "System/Funciones.php";

                if (!defined('DNS') || strlen('DNS') == "") {

                    echo "<div class='alert alert-warning' role='alert'>
                    DEBE CREAR LA CONSTANTE <strong>'DNS'</strong>
                    <br />
                    CON SU VALOR DE CONEXION
                </div>";

                    return;
                }

                if (!defined('USUARIO') || strlen('USUARIO') == "") {

                    echo "<div class='alert alert-warning' role='alert'>
                    DEBE CREAR LA CONSTANTE <strong>'USUARIO'</strong>
                    <br />
                    CON SU VALOR DE CONEXION
                </div>";

                    return;
                }

                if (!defined('PASS') || strlen('PASS') == "") {

                    echo "<div class='alert alert-warning' role='alert'>
                    DEBE CREAR LA CONSTANTE <strong>'PASS'</strong>
                    <br />
                    CON SU VALOR DE CONEXION
                </div>";

                    return;
                }

                if (!defined('MOTOR') || strlen('MOTOR') == "") {

                    echo "<div class='alert alert-warning' role='alert'>
                    DEBE CREAR LA CONSTANTE <strong>'MOTOR'</strong>
                    <br />
                    CON SU VALOR DE CONEXION <strong>'ODBC'</strong>
                </div>";

                    return;
                }


                $conexion = new DBConexion();
                $status = $conexion->Conexion();

                if ($status) {

                    echo "<div class='alert alert-success' role='alert'>
                    CONEXION ESTABLECIDA CON ÉXITO
                </div>";
                } else {

                    echo "<div class='alert alert-danger' role='alert'>
                    Error de conexión, verificar parámetros de conexión
                    <BR/>
                    Para más detalle revisar los logs del sistema
                </div>";
                }
                ?>
            </div>
        </div>

    </div>
</body>

</html>
<?php
// phpinfo();