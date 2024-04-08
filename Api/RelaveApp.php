<?php
require_once "ConfigCab.php";
require_once "Token.php";

//$verificaToken = Token::VerificarToken($headers);

//if (!$verificaToken['estado']) return print_r(json_encode(Funciones::RespuestaJson(2, $verificaToken['mensaje'])));

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CRelaveApp.php";

    $relave = new Relaves();

    $metodo = $data['metodo'];

    unset($data['metodo']);

    switch (strtoupper($metodo)) {
        case 'RELAVE_LISTAR':
            return print_r(json_encode($relave->Listar($data)));

        case 'RELAVE_LENCERIA':
            return print_r(json_encode($relave->Listar_Lenceria($data)));

        case 'RELAVE_MOTIVO':
            return print_r(json_encode($relave->Listar_Motivo()));

        case 'RELAVE_GUARDA':
            return print_r(json_encode($relave->Guardar($data, $_FILES)));

        case 'RELAVE_FINALI':
            return print_r(json_encode($relave->Finalizar($data, $_FILES)));

        case 'RELAVE_HABI':
            return print_r(json_encode($relave->Listar_Habitacion($data)));
            
        case 'REMOJO_ALAS':
            return print_r(json_encode($relave->Listar_Alas($data)));
			
		case 'RELAVE_LISTARAPP':
            return print_r(json_encode($relave->ListarApp($data)));

        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establecer el metodo a utilizar")));
}
