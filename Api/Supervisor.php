<?php
require_once "ConfigCab.php";
require_once "Token.php";

//$verificaToken = Token::VerificarToken($headers);

//if(!$verificaToken['estado']) return Funciones::RespuestaJson(2, $verificaToken['mensaje']);

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CSupervisor.php";

    $supervisor = new Supervisor();

    $metodo = $data['metodo'];

    unset($data['metodo']);

    switch (strtoupper($metodo)) {
        case 'CONSULTA_SUPER':
            return print_r(json_encode($supervisor->Consultar($data)));
			
        case 'CONSULTA_EMPLEADO':
            return print_r(json_encode($supervisor->Consultar2($data)));


        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible", $data)));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establer el metodo a utilizar")));
}
