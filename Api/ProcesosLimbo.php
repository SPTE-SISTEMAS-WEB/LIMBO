<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");

header("Content-Type: application/json; charset=UTF-8");
require_once "ConfigCab.php";
require_once "Token.php";

// $verificaToken = Token::VerificarToken($headers);

// if(!$verificaToken['estado']) return print_r(json_encode(Funciones::RespuestaJson(3, $verificaToken['mensaje'])));

//$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['metodo'])) {

    require_once "../Config.php";
    require_once "../System/conexion.php";
    require_once "Classes/CProcesosLimbo.php";

    $procesosLimbo = new ProcesosLimbo();

    $metodo = $data['metodo'];

    unset($data['metodo']);

    switch (strtoupper($metodo)) {
		/***************************************************************************	CARGAS INICIALES *******/
            case 'LISTAR_EMPRESAS':  // login inicial
            return print_r(json_encode($procesosLimbo->ListarEmpresas($data)));

		case 'LISTAR_USUARIOS':  // 
            return print_r(json_encode($procesosLimbo->ListarUsuarios($data)));
			
		case 'LISTAR_BRASALETES':  // 
            return print_r(json_encode($procesosLimbo->ListarBrazaletes($data)));
			
		case 'LISTAR_PEDIDOS':  // 
            return print_r(json_encode($procesosLimbo->ListarPedidos($data)));
			
		case 'DETALLE_PEDIDO':  // 
            return print_r(json_encode($procesosLimbo->DetallePedidos($data)));
			
		case 'CAT_BRASALETES':  // 
            return print_r(json_encode($procesosLimbo->CategoriaBrazaletes($data)));
			
		case 'BUSCAR_BRASALETE':  // 
            return print_r(json_encode($procesosLimbo->BuscarBrazalete($data)));
			
		case 'BUSCAR_PEDIDO':  // 
            return print_r(json_encode($procesosLimbo->BuscarPedido($data)));
			
		case 'INGRESO_MAESTRO':  // 
            return print_r(json_encode($procesosLimbo->IngresoMaestro($data)));
		
		case 'AUMENTO_CUPO':  // 
            return print_r(json_encode($procesosLimbo->AumentoCupo($data)));
			
		case 'INGRESO_CLIENTE':  // 
            return print_r(json_encode($procesosLimbo->IngresoCliente($data)));
			
			
			
/************************ INTERFASE PRODUCTOS *********************************/

			
		case 'LISTAR_PRODUCTOS':  //
            return print_r(json_encode($procesosLimbo->ListarProductos($data)));
			
		case 'LISTAR_CATEGORIAS':  //
            return print_r(json_encode($procesosLimbo->ListarCategorias($data)));
			
		case 'SAVE_ORDERS':  //
            return print_r(json_encode($procesosLimbo->GuardarPedidos($data)));
			
		case 'SAVE_DETAIL_ORDERS':  //
            return print_r(json_encode($procesosLimbo->GuardarDetallePedidos($data)));

            case 'NULL_DETAIL_ORDERS':  //
            return print_r(json_encode($procesosLimbo->AnularDetallePedidos($data)));

            case 'DISCOUNT_DETAIL_ORDERS':  //
            return print_r(json_encode($procesosLimbo->DescuentoDetallePedidos($data)));

            case 'PRECUENTA_ORDERS':  //
            return print_r(json_encode($procesosLimbo->PrecuentaPedidos($data)));

            case 'SAVE_FACTURAS':  //
            return print_r(json_encode($procesosLimbo->GuardarFacturas($data)));

          /*  case 'SECUENCIA_FACTURAS':  //
            return print_r(json_encode($procesosLimbo->BuscoSecuencialFactura($data)));*/


            
            
		
/************************ OTRAS CONSULTAS *********************************/

			
            case 'LISTAR_FACTURAS':  //
            return print_r(json_encode($procesosLimbo->BuscarFacturas($data)));

            case 'LISTAR_FORMAS_PAGOS':  //
                  return print_r(json_encode($procesosLimbo->BuscarFormasPagos($data)));
			
        default:
            return print_r(json_encode(Funciones::RespuestaJson(2, "Metodo no disponible")));
    }
} else {
    print_r(json_encode(Funciones::RespuestaJson(3, "Debe establecer el metodo a utilizar")));
}
