<?php
require_once "ConfigCab.php";
require_once "Token.php";

// PROCESOS PARA LA APLICACION DEL REGISTRO STOCK DEL BUHO 

if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CProductosApp.php";

    $productos = new Productos();

    $metodo = $data['metodo'];

    unset($data['metodo']);
	
    switch (strtoupper($metodo)) {

        case 'GUARDAR_PRODUCTO':
            return print_r(json_encode($productos->GuardarProducto($data)));
			
		case 'INGRESAR':
            return  print_r(json_encode($productos->Loggin($data)));	

        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establecer el metodo a utilizar")));
}
