<?php
require_once "ConfigCab.php";

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CCliente.php";

    $cliente = new Cliente();

    $metodo = $data['metodo'];

    unset($data['metodo']);

    switch (strtoupper($metodo)) {
        case 'BUSCAR_CLIENTE':
            return print_r(json_encode($cliente->Buscar_Cliente($data)));

        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establer el metodo a utilizar")));
}
