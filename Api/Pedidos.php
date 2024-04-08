<?php
require_once "ConfigCab.php";
require_once "Token.php";

// $verificaToken = Token::VerificarToken($headers);

// if(!$verificaToken['estado']) return print_r(json_encode(Funciones::RespuestaJson(3, $verificaToken['mensaje'])));

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CMantenimiento.php";

    $mantenimientos = new Mantenimiento();

    $metodo = $data['metodo'];

    unset($data['metodo']);
	
    switch (strtoupper($metodo)) {
        case 'LISTAR_MANTEN':
            return print_r(json_encode($mantenimientos->Listar($data)));

        case 'GUARDAR_MANTENI':
            return print_r(json_encode($mantenimientos->Guardar($data)));

        case 'MANTEN_HOTEL':
            return print_r(json_encode($mantenimientos->ListarMantenHotel($data)));

        case 'MANTEN_INICIA':
            return print_r(json_encode($mantenimientos->Iniciar($data)));

        case 'MANTEN_FINALI':
            return print_r(json_encode($mantenimientos->Finalizar($data)));

        case 'MANTEN_CONTIN':
            return print_r(json_encode($mantenimientos->Continuar($data)));

        case 'MANTEN_PAUSAR':
            return print_r(json_encode($mantenimientos->Pausar($data)));

        case 'MANTEN_GUARDAR':
            return print_r(json_encode($mantenimientos->GuardarObservacion($data)));
			
			//NUEVA APP  
		case 'LISTAR_MANTENAPP':
            return print_r(json_encode($mantenimientos->ListarApp($data)));
		
		case 'LISTAR_MANTENAPPF':
            return print_r(json_encode($mantenimientos->ListarAppf($data)));
			
		case 'MANTEN_HOTELAPP':
            return print_r(json_encode($mantenimientos->ListarMantenHotelApp($data)));
		
		case 'MANTEN_GUARDARAPP':
            return print_r(json_encode($mantenimientos->GuardarObservacionApp($data)));

        case 'LISTADO_MANTEN_HOTEL':
            return print_r(json_encode($mantenimientos->ListadoMantenHotel($data))); //USADO EN APK MANTENIMIENTO 



		/*************      APP MANTENIMIENTO HOTEL INTERFASE MANTENIMIENO ***************/
		case 'SUBIR_ARCHIVO_INICIAR': //subida de archivos botton iniciar
            return print_r(json_encode($mantenimientos->GuardarIni($data, $_FILES)));
			
		case 'SUBIR_ARCHIVO_PAUSE': //subida de archivos app mt 
            return print_r(json_encode($mantenimientos->GuardarPau($data, $_FILES)));
			
		case 'SUBIR_ARCHIVO_CONTINUE': //subida de archivos app mt 
            return print_r(json_encode($mantenimientos->GuardarCon($data, $_FILES)));
			
		case 'SUBIR_ARCHIVO_END': //subida de archivos app mt 
            return print_r(json_encode($mantenimientos->GuardarEnd($data, $_FILES)));
			
        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establecer el metodo a utilizar")));
}
