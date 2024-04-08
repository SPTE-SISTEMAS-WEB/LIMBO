<?php
require_once "ConfigCab.php";

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CLogginLimbo.php";

    $logginLimbo = new LogginLimbo();

    $metodo = $data['metodo'];

    unset($data['metodo']);

    switch ($metodo) {
		
        case 'INGRESAR':
            return  print_r(json_encode($logginLimbo->Loggin($data)));
			
        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establer el metodo a utilizar")));
}
