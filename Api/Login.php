<?php
require_once "ConfigCab.php";

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CLoggin.php";

    $loggin = new Loggin();

    $metodo = $data['metodo'];

    unset($data['metodo']);

    switch ($metodo) {
        case 'INGRESAR':
            return  print_r(json_encode($loggin->Loggin($data)));
			
		case 'INGRESAR2':
            return  print_r(json_encode($loggin->Loggin2($data)));
			
		case 'REGISTRO_PHONE':
            return  print_r(json_encode($loggin->LogginPhone($data)));

        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establer el metodo a utilizar")));
}
