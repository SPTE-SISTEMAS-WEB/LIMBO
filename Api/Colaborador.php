<?php
require_once "ConfigCab.php";
require_once "Token.php";

$verificaToken = Token::VerificarToken($headers);

if (!$verificaToken['estado']) return Funciones::RespuestaJson(2, $verificaToken['mensaje']);

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CColaborador.php";

    $colaborador = new Colaborador();

    $metodo = $data['metodo'];

    $data['sucursalToken'] = ($verificaToken['data']['scopes']->idsucursal);

    unset($data['metodo']);

    switch (strtoupper($metodo)) {
        case 'BUSCAR_EMPLEADO':
            return print_r(json_encode($colaborador->BuscarColaborador($data)));

        case 'CONSULTA_CAMARERA':
            return (print_r(json_encode($colaborador->ConsultarCamarera($data))));

        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establer el metodo a utilizar")));
}
