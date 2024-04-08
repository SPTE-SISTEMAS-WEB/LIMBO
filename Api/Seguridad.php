<?php
require_once "ConfigCab.php";

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CSeguridad.php";

    $seguridad = new Seguridad();

    $metodo = $data['metodo'];

    unset($data['metodo']);

    switch (strtoupper($metodo)) {
        case 'GENERAR_TOKEN':
            return print_r(json_encode($seguridad->GenerarToken($data)));

        case 'GENERAR_TOKEN_USUARIO':
            return print_r(json_encode($seguridad->GenerarTokenUsuario($data)));


        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establer el metodo a utilizar")));
}
