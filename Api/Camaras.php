<?php
require_once "ConfigCab.php";
require_once "Token.php";

// $verificaToken = Token::VerificarToken($headers);

// if(!$verificaToken['estado']) return print_r(json_encode(Funciones::RespuestaJson(3, $verificaToken['mensaje'])));

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CCamaras.php";

    $camaras = new Camaras();

    $metodo = $data['metodo'];

    unset($data['metodo']);
	
    switch (strtoupper($metodo)) {
        case 'LISTAR_CAMARAS':
            return print_r(json_encode($camaras->ListarCamaras($data)));

        case 'GUARDAR_CAMARAS':
            return print_r(json_encode($camaras->GuardarCamaras($data)));

        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establecer el metodo a utilizar")));
}
