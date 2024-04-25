<?php

class ProcesosLimbo extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }
	
	

	public function ListarEmpresas($data)
    {
        try {

            $sql = "SELECT empr_cod_empr,empr_nom_empr FROM saeempr WHERE empr_cod_empr in (2,3) ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();
            
            $valor_inicial = array(
                'empr_cod_empr' => '0',
                'empr_nom_empr' => 'SELECCIONE',
                // Agrega más claves y valores según sea necesario
            );
            
            foreach ($exec as $item) {

                $item['empr_cod_empr'] = trim($item['empr_cod_empr']);
				$item['empr_nom_empr'] = trim($item['empr_nom_empr']);

                $items[] = $item;
            }
            array_unshift($items, $valor_inicial);

            return Funciones::RespuestaJson(1, "", array("empresas" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }


    public function ListarSucursal($data)
    {
        try {

            $empresa = trim($data['empresa']);

            $sql = "SELECT sucu_cod_sucu as idsucursal,sucu_nom_sucu as nombre_sucursal FROM saesucu WHERE sucu_cod_empr =  '$empresa' and sucu_cod_sucu in (600,926) ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

                $item['idsucursal']      = trim($item['idsucursal']);
				$item['nombre_sucursal'] = trim($item['nombre_sucursal']);

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("sucursales" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	

	public function ListarUsuarios($data)
    {
        try {
			
			if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe seleccionar la empresa");

            $empresa = trim($data['empresa']);

            $sql = "SELECT usua_nom_usua,usua_cod_usua FROM saeusua  LEFT JOIN saeacce on saeacce.acce_cod_usua=saeusua.usua_cod_usua WHERE  ACCE_COD_EMPR = '$empresa' GROUP BY usua_nom_usua,usua_cod_usua ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

                $item['usua_nom_usua']      = trim($item['usua_nom_usua']);
				$item['usua_cod_usua']      = trim($item['usua_cod_usua']);

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("usuarios" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	/********************************************************  BRAZALETES ***********/

	public function ListarBrazaletes($data)
    {
        try {

			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);
			
            $sql = "SELECT rbra_cod_rbra,rbra_cod_pltu,rbra_cod_braz,rbra_tip_braz,rbra_tip_grup,rbra_bra_grup, rbra_est_rbra ,rbra_val_cupo,rbra_val_cons,rbra_val_canc,rbra_cod_usua,rbra_val_pedi , rbra_hor_ingr,rbra_usu_vend,rbra_cod_empl,rbra_nom_clie,rbra_cov_rbra FROM saerbra 
			WHERE  rbra_cod_empr = '$empresa'  AND rbra_cod_sucu = '$sucursal' ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

				$item['rbra_cod_rbra'] = isset($item['rbra_cod_rbra'])? $item['rbra_cod_rbra'] : 'N/P' ;
				$item['rbra_cod_pltu'] = isset($item['rbra_cod_pltu'])? $item['rbra_cod_pltu'] : 'N/P' ;
				$item['rbra_cod_braz'] = isset($item['rbra_cod_braz'])? $item['rbra_cod_braz'] : 'N/P' ;
				$item['rbra_tip_braz'] = isset($item['rbra_tip_braz'])? $item['rbra_tip_braz'] : 'N/P' ;
				$item['rbra_tip_grup'] = isset($item['rbra_tip_grup'])? $item['rbra_tip_grup'] : 'N/P' ;
				$item['rbra_bra_grup'] = isset($item['rbra_bra_grup'])? $item['rbra_bra_grup'] : 'N/P' ;
				
				$item['rbra_est_rbra'] = isset($item['rbra_est_rbra'])? $item['rbra_est_rbra'] : 'N/P' ;
				$item['rbra_val_cupo'] = isset($item['rbra_val_cupo'])? strval(intval($item['rbra_val_cupo'])) : 'N/P' ;
				$item['rbra_val_cons'] = isset($item['rbra_val_cons'])? $item['rbra_val_cons'] : 'N/P' ;
				$item['rbra_val_canc'] = isset($item['rbra_val_canc'])? $item['rbra_val_canc'] : 'N/P' ;
				$item['rbra_cod_usua'] = isset($item['rbra_cod_usua'])? $item['rbra_cod_usua'] : 'N/P' ;

				$item['rbra_val_pedi'] = isset($item['rbra_val_pedi'])? $item['rbra_val_pedi'] : 'N/P' ;
				$item['rbra_hor_ingr'] = isset($item['rbra_hor_ingr'])? $item['rbra_hor_ingr'] : 'N/P' ;
				$item['rbra_usu_vend'] = isset($item['rbra_usu_vend'])? $item['rbra_usu_vend'] : 'N/P' ;
				$item['rbra_cod_empl'] = isset($item['rbra_cod_empl'])? $item['rbra_cod_empl'] : 'N/P' ;
				$item['rbra_nom_clie'] = isset($item['rbra_nom_clie'])? $item['rbra_nom_clie'] : 'N/P' ;
				$item['rbra_cov_rbra'] = isset($item['rbra_cov_rbra'])? strval(intval($item['rbra_cov_rbra'])) : 'N/P' ;


               $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "Descarga exitosa!", array("brazaletes" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	public function CategoriaBrazaletes($data)
    {
        try {
			
			if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe seleccionar la empresa");

            $empresa = trim($data['empresa']);
			$sucursal = trim($data['sucursal']);


            $sql = "SELECT  * from saetbra WHERE  tbra_cod_empr = '$empresa'  AND tbra_cod_sucu = '$sucursal'";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {
				
                $item['tbra_cod_tbra']      = trim($item['tbra_cod_tbra']);
				$item['tbra_cod_sec']       = trim($item['tbra_cod_sec']);
				$item['tbra_nom_tbra']      = trim($item['tbra_nom_tbra']);
				$item['tbra_tip_tbra']      = trim($item['tbra_tip_tbra']);

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("usuarios" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	


	public function  BuscarBrazalete($data)
    {
        try {
			
			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);
			$codigo = trim($data['code']);

            $sql = "SELECT  rbra_cod_rbra,rbra_cod_pltu,rbra_cod_braz,rbra_tip_braz,rbra_tip_grup,rbra_bra_grup, rbra_est_rbra ,rbra_val_cupo,rbra_val_cons,rbra_val_canc,rbra_cod_usua,rbra_val_pedi , rbra_hor_ingr,rbra_usu_vend,rbra_cod_empl,rbra_nom_clie,rbra_cov_rbra,rbra_fot_rbra     FROM saerbra  WHERE rbra_cod_empr = '$empresa'  AND rbra_cod_sucu = '$sucursal' AND rbra_cod_braz = '$codigo' and rbra_est_rbra = 'A' ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

				$item['rbra_cod_rbra'] = isset($item['rbra_cod_rbra'])? $item['rbra_cod_rbra'] : 'N/P' ;
				$item['rbra_fot_rbra'] = isset($item['rbra_fot_rbra'])? $item['rbra_fot_rbra'] : 'N/P' ;
				$item['rbra_cod_pltu'] = isset($item['rbra_cod_pltu'])? $item['rbra_cod_pltu'] : 'N/P' ;
				$item['rbra_cod_braz'] = isset($item['rbra_cod_braz'])? $item['rbra_cod_braz'] : 'N/P' ;
				$item['rbra_tip_braz'] = isset($item['rbra_tip_braz'])? $item['rbra_tip_braz'] : 'N/P' ;
				$item['rbra_tip_grup'] = isset($item['rbra_tip_grup'])? $item['rbra_tip_grup'] : 'N/P' ;

				$item['rbra_bra_grup'] = isset($item['rbra_bra_grup'])? $item['rbra_bra_grup'] : 'N/P' ;
				$item['rbra_est_rbra'] = isset($item['rbra_est_rbra'])? $item['rbra_est_rbra'] : 'N/P' ;
				$item['rbra_val_cupo'] = isset($item['rbra_val_cupo'])? $item['rbra_val_cupo'] : 'N/P' ;
				$item['rbra_val_cons'] = isset($item['rbra_val_cons'])? $item['rbra_val_cons'] : 'N/P' ;
				$item['rbra_val_canc'] = isset($item['rbra_val_canc'])? $item['rbra_val_canc'] : 'N/P' ;
				$item['rbra_cod_usua'] = isset($item['rbra_cod_usua'])? $item['rbra_cod_usua'] : 'N/P' ;

				$item['rbra_val_pedi'] = isset($item['rbra_val_pedi'])? $item['rbra_val_pedi'] : 'N/P' ;
				$item['rbra_hor_ingr'] = isset($item['rbra_hor_ingr'])? $item['rbra_hor_ingr'] : 'N/P' ;
				$item['rbra_usu_vend'] = isset($item['rbra_usu_vend'])? $item['rbra_usu_vend'] : 'N/P' ;
				$item['rbra_cod_empl'] = isset($item['rbra_cod_empl'])? $item['rbra_cod_empl'] : 'N/P' ;
				$item['rbra_nom_clie'] = isset($item['rbra_nom_clie'])? $item['rbra_nom_clie'] : 'N/P' ;
				$item['rbra_cov_rbra'] = isset($item['rbra_cov_rbra'])? $item['rbra_cov_rbra'] : 'N/P' ;

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("brazalete" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	




    public function IngresoCliente($data) /*** UPDATE COVER - CLIENTE  - ESTADO ***/
    {
        try {
            if (empty($data['nombre'])) return Funciones::RespuestaJson(2, "El nombre cliente es requerido!");
            if (empty($data['ruc'])) return Funciones::RespuestaJson(2, "El ruc cliente es requerido!");
			
            $brazalete = strval($data['brazalete']);
			$idbrazalete = intval($data['idbrazalete']);
			$sucursal = intval($data['sucursal']);
			$empresa = intval($data['empresa']);
			$nombre  = strtoupper(strval($data['nombre']));
			$ruc    = strval($data['ruc']);

			$cupo    = intval($data['cupo']);
			$date = date("n/d/Y");
            $time = date("n/d/Y H:i:s");
 
            $sql = "UPDATE saerbra SET rbra_nom_clie='$nombre',rbra_cod_empl='$ruc',rbra_val_cupo='$cupo',rbra_est_rbra='L', rbra_fec_ingr='$date' WHERE rbra_cod_rbra = '$idbrazalete'";
           // echo $sql;exit();
			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo actualizar!");

            return Funciones::RespuestaJson(1, "Registro exitoso!");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	
	
	
    public function IngresoMaestro($data) /*** UPDATE BRAZALETE MAESTRO ***/
    {
        try {
            if (empty($data['empresa'])) return Funciones::RespuestaJson(2, "El nombre cliente es requerido!");
            if (empty($data['sucursal'])) return Funciones::RespuestaJson(2, "El ruc cliente es requerido!");
			
            $brazalete = $data['code'];
			$codigo    = $data['maestro'];
 
            $sql = "UPDATE saerbra SET rbra_bra_grup ='$codigo' WHERE rbra_cod_braz = '$brazalete'"; 
			
			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo actualizar!");

            return Funciones::RespuestaJson(1, "Registro exitoso!", $data);
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	
	public function AumentoCupo($data) /*** UPDATE CUPO  ***/
    {
        try {

            if (empty($data['nombre'])) return Funciones::RespuestaJson(2, "El nombre cliente es requerido!");
            if (empty($data['ruc'])) return Funciones::RespuestaJson(2, "El ruc cliente es requerido!");

            $brazalete = $data['brazalete'];
			$nombre    = strval($data['nombre']);
			$ruc    = strval($data['ruc']);
			$cover    = intval(trim($data['cover']));
			$cupo    = intval($data['cupo']);
			$date = date("n/d/Y");
            $time =  date("H:i:s");
            $empresa    = intval($data['empresa']);
            $sucursal    = intval($data['sucursal']);
            $codigo    = $data['codigomaestro'];

 

             $sql1 = "SELECT  rbra_cod_rbra FROM saerbra  WHERE rbra_cod_empr = '$empresa'  AND rbra_cod_sucu = '$sucursal' AND rbra_cod_braz = '$codigo' and rbra_est_rbra != 'L' ";

            $exec1 = $this->Consulta($sql1, true);

            if ($exec1) return Funciones::RespuestaJson(2, "Brazalete maestro no autorizado");

            /**********buscamos que no posea un brazalete maestro  */

       //    $sql12 = "SELECT  rbra_cod_rbra FROM saerbra  WHERE rbra_cod_empr = '$empresa'  AND rbra_cod_sucu = '$sucursal' AND rbra_cod_braz = '$codigo'  ";

         //   $exec12 = $this->Consulta($sql12, true);

           // if (!$exec12) return Funciones::RespuestaJson(2, "Requiere brazalete maestro para cambiar cupoestro no autorizado");  


            /**********INCREMENTAMOS EL CUPO   */
            
            $sql = "UPDATE saerbra SET rbra_val_cupo='$cupo' WHERE rbra_cod_braz = '$brazalete'";

           // echo $sql ;

			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo actualizar!");

            return Funciones::RespuestaJson(1, "Registro exitoso!", $data);
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	
	public function  BuscaInfoBrazalete($data)
    {
        try {
			
			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);
			$codigo = trim($data['code']);

            $sql = "SELECT  rbra_cod_rbra,rbra_cod_pltu,rbra_cod_braz,rbra_tip_braz,rbra_tip_grup,rbra_bra_grup, rbra_est_rbra ,rbra_val_cupo,rbra_val_cons,rbra_val_canc,rbra_cod_usua,rbra_val_pedi , rbra_hor_ingr,rbra_usu_vend,rbra_cod_empl,rbra_nom_clie,rbra_cov_rbra     FROM saerbra  WHERE rbra_cod_empr = '$empresa'  AND rbra_cod_sucu = '$sucursal' AND rbra_cod_braz = '$codigo' and rbra_est_rbra = 'A' ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

				$item['rbra_cod_rbra'] = isset($item['rbra_cod_rbra'])? $item['rbra_cod_rbra'] : 'N/P' ;
				$item['rbra_cod_pltu'] = isset($item['rbra_cod_pltu'])? $item['rbra_cod_pltu'] : 'N/P' ;
				$item['rbra_cod_braz'] = isset($item['rbra_cod_braz'])? $item['rbra_cod_braz'] : 'N/P' ;
				$item['rbra_tip_braz'] = isset($item['rbra_tip_braz'])? $item['rbra_tip_braz'] : 'N/P' ;
				$item['rbra_tip_grup'] = isset($item['rbra_tip_grup'])? $item['rbra_tip_grup'] : 'N/P' ;
				$item['rbra_bra_grup'] = isset($item['rbra_bra_grup'])? $item['rbra_bra_grup'] : 'N/P' ;
				
				$item['rbra_est_rbra'] = isset($item['rbra_est_rbra'])? $item['rbra_est_rbra'] : 'N/P' ;
				$item['rbra_val_cupo'] = isset($item['rbra_val_cupo'])? $item['rbra_val_cupo'] : 'N/P' ;
				$item['rbra_val_cons'] = isset($item['rbra_val_cons'])? $item['rbra_val_cons'] : 'N/P' ;
				$item['rbra_val_canc'] = isset($item['rbra_val_canc'])? $item['rbra_val_canc'] : 'N/P' ;
				$item['rbra_cod_usua'] = isset($item['rbra_cod_usua'])? $item['rbra_cod_usua'] : 'N/P' ;

				$item['rbra_val_pedi'] = isset($item['rbra_val_pedi'])? $item['rbra_val_pedi'] : 'N/P' ;
				$item['rbra_hor_ingr'] = isset($item['rbra_hor_ingr'])? $item['rbra_hor_ingr'] : 'N/P' ;
				$item['rbra_usu_vend'] = isset($item['rbra_usu_vend'])? $item['rbra_usu_vend'] : 'N/P' ;
				$item['rbra_cod_empl'] = isset($item['rbra_cod_empl'])? $item['rbra_cod_empl'] : 'N/P' ;
				$item['rbra_nom_clie'] = isset($item['rbra_nom_clie'])? $item['rbra_nom_clie'] : 'N/P' ;
				$item['rbra_cov_rbra'] = isset($item['rbra_cov_rbra'])? $item['rbra_cov_rbra'] : 'N/P' ;

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("brazalete" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	


	
	
	
	
	
		/********************************************************  PEDIDOS ***********/
	
	public function ListarPedidos($data) //****** LISTA DE PEDIDOS DEL MESERO 
    {
        try {
			
			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);
			$fecha = trim($data['fecha']);
			$mesero = trim($data['mesero']);

            $sql = "SELECT  pedtou_compan,pedtou_sucurs,pedtou_pedtou, pedtou_fecped, pedtou_mesped, pedtou_horped, pedtou_estado, pedtou_numcli,
							pedtou_mesero, pedtou_precue,pedtou_observ FROM tb_pedtou WHERE pedtou_compan = '$empresa' AND pedtou_sucurs= '$sucursal' AND pedtou_fecped='$fecha' and pedtou_mesero='$mesero' ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {
				
				$item['pedtou_compan']      = isset($item['pedtou_compan'])? $item['pedtou_compan'] : 'N/P' ;
				$item['pedtou_sucurs']      = isset($item['pedtou_sucurs'])? $item['pedtou_sucurs'] : 'N/P' ;
                $item['pedtou_pedtou']      = isset($item['pedtou_pedtou'])? $item['pedtou_pedtou'] : 'N/P' ;  
				$item['pedtou_fecped']      = isset($item['pedtou_fecped'])? $item['pedtou_fecped'] : 'N/P' ;    
				$item['pedtou_mesped']      = isset($item['pedtou_mesped'])? $item['pedtou_mesped'] : 'N/P' ;   
				$item['pedtou_horped']      = isset($item['pedtou_horped'])? $item['pedtou_horped'] : 'N/P' ; 
				$item['pedtou_estado']      = isset($item['pedtou_estado'])? $item['pedtou_estado'] : 'N/P' ;
				$item['pedtou_numcli']      = isset($item['pedtou_numcli'])? $item['pedtou_numcli'] : 'N/P' ;   
				$item['pedtou_mesero']      = isset($item['pedtou_mesero'])? $item['pedtou_mesero'] : 'N/P' ;   
				$item['pedtou_precue']      = isset($item['pedtou_precue'])? $item['pedtou_precue'] : 'N/P' ;  
				$item['pedtou_observ'] 		= isset($item['pedtou_observ'])? $item['pedtou_observ'] : 'N/P' ;  

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("pedidos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	public function DetallePedidos($data) // BUSQUEDA DE UN SOLO PEDIDO 
    {
        try {
			
			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);
			$idpedido = trim($data['idpedido']);
			
            $sql = " SELECT    pedres_pedres  ,pedres_compan,pedres_sucurs,  pedres_fecped ,  pedres_horped ,  pedres_mesped ,  pedres_cantid ,  pedres_codigo ,
					pedres_nompro ,  pedres_bodega ,  pedres_precio ,  pedres_estado ,  pedres_detall ,  pedres_poriva ,  pedres_catego ,
					pedres_pedtou ,  pedres_estcam  , pedres_impres  ,  pedres_enviaa , pedres_filpad , pedres_filnum , 	
					pedres_pventa ,   pedres_mesero ,   pedres_obserc , pedres_origen ,  pedres_numero ,  pedres_cortes ,  pedres_admini , pedres_motivo , pedres_precue ,  pedres_pordes ,  pedres_valdes ,  pedres_anufec , pedres_anuhor
			FROM tb_pedres  WHERE pedres_compan = '$empresa' AND pedres_sucurs= '$sucursal' AND pedres_pedtou= '$idpedido' ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

				  $item['pedres_pedres']      = isset($item['pedres_pedres'])? $item['pedres_pedres'] : 'N/P' ; 
				  $item['pedres_compan']      = isset($item['pedres_compan'])? $item['pedres_compan'] : 'N/P' ; 
				  $item['pedres_sucurs']      = isset($item['pedres_sucurs'])? $item['pedres_sucurs'] : 'N/P' ; 
				  $item['pedres_fecped']      = isset($item['pedres_fecped'])? $item['pedres_fecped'] : 'N/P' ; 
				  $item['pedres_horped']      = isset($item['pedres_horped'])? $item['pedres_horped'] : 'N/P' ; 
				  $item['pedres_mesped']      = isset($item['pedres_mesped'])? $item['pedres_mesped'] : 'N/P' ; 
				  $item['pedres_cantid']      = isset($item['pedres_cantid'])? $item['pedres_cantid'] : 'N/P' ; 
				  $item['pedres_codigo']      = isset($item['pedres_codigo'])? $item['pedres_codigo'] : 'N/P' ; 
				  
				  $item['pedres_nompro']      = isset($item['pedres_nompro'])? $item['pedres_nompro'] : 'N/P' ; 
				  $item['pedres_bodega']      = isset($item['pedres_bodega'])? $item['pedres_bodega'] : 'N/P' ; 
				  $item['pedres_precio']      = isset($item['pedres_precio'])? $item['pedres_precio'] : 'N/P' ; 
				  $item['pedres_estado']      = isset($item['pedres_estado'])? $item['pedres_estado'] : 'N/P' ; 
				  $item['pedres_detall']      = isset($item['pedres_detall'])? $item['pedres_detall'] : 'N/P' ; 
				  $item['pedres_poriva']      = isset($item['pedres_poriva'])? $item['pedres_poriva'] : 'N/P' ; 
				  $item['pedres_catego']      = isset($item['pedres_catego'])? $item['pedres_catego'] : 'N/P' ; 
				  
				  $item['pedres_pedtou']      = isset($item['pedres_pedtou'])? $item['pedres_pedtou'] : 'N/P' ; 
				  $item['pedres_estcam']      = isset($item['pedres_estcam'])? $item['pedres_estcam'] : 'N/P' ; 
				  $item['pedres_enviaa']      = isset($item['pedres_enviaa'])? $item['pedres_enviaa'] : 'N/P' ; 
				  $item['pedres_filpad']      = isset($item['pedres_filpad'])? $item['pedres_filpad'] : 'N/P' ; 
				  $item['pedres_filnum']      = isset($item['pedres_filnum'])? $item['pedres_filnum'] : 'N/P' ; 
				  
				  $item['pedres_pventa']      = isset($item['pedres_pventa'])? $item['pedres_pventa'] : 'N/P' ; 
				  $item['pedres_mesero']      = isset($item['pedres_mesero'])? $item['pedres_mesero'] : 'N/P' ; 
				  $item['pedres_obserc']      = isset($item['pedres_obserc'])? trim($item['pedres_obserc']) : 'N/P' ; 
				  $item['pedres_origen']      = isset($item['pedres_origen'])? $item['pedres_origen'] : 'N/P' ; 
				  $item['pedres_numero']      = isset($item['pedres_numero'])? $item['pedres_numero'] : 'N/P' ; 
				  $item['pedres_cortes']      = isset($item['pedres_cortes'])? $item['pedres_cortes'] : 'N/P' ; 
				  
				  $item['pedres_admini']      = isset($item['pedres_admini'])? $item['pedres_admini'] : 'N/P' ; 
				  $item['pedres_motivo']      = isset($item['pedres_motivo'])? $item['pedres_motivo'] : 'N/P' ; 
				  $item['pedres_precue']      = isset($item['pedres_precue'])? $item['pedres_precue'] : 'N/P' ;
					
				  $item['pedres_pordes']      = isset($item['pedres_pordes'])? $item['pedres_pordes'] : 'N/P' ; 
				  $item['pedres_valdes']      = isset($item['pedres_valdes'])? $item['pedres_valdes'] : 'N/P' ; 
				  $item['pedres_anufec']      = isset($item['pedres_anufec'])? $item['pedres_anufec'] : 'N/P' ; 
				  $item['pedres_anuhor']      = isset($item['pedres_anuhor'])? $item['pedres_anuhor'] : 'N/P' ; 

 
                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("detalles" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	
	public function DetallePedidos2($data) // BUSQUEDA DE TODOS LOS PEDIDOS  	
    {
        try {
			
			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);
			$idpedido = trim($data['idpedido']);
			
            $sql = " SELECT    pedres_pedres  ,pedres_compan,pedres_sucurs,  pedres_fecped ,  pedres_horped ,  pedres_mesped ,  pedres_cantid ,  pedres_codigo ,
					pedres_nompro ,  pedres_bodega ,  pedres_precio ,  pedres_estado ,  pedres_detall ,  pedres_poriva ,  pedres_catego ,
					pedres_pedtou ,  pedres_estcam  , pedres_impres  ,  pedres_enviaa , pedres_filpad , pedres_filnum , 	
					pedres_pventa ,   pedres_mesero ,   pedres_obserc , pedres_origen ,  pedres_numero ,  pedres_cortes ,  pedres_admini , pedres_motivo , pedres_precue ,  pedres_pordes ,  pedres_valdes ,  pedres_anufec , pedres_anuhor
			FROM tb_pedres  WHERE pedres_compan = '$empresa' AND pedres_sucurs= '$sucursal' AND pedres_pedtou= '$idpedido' ";
		
            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

				  $item['pedres_pedres']      = isset($item['pedres_pedres'])? $item['pedres_pedres'] : 'N/P' ; 
				  $item['pedres_compan']      = isset($item['pedres_compan'])? $item['pedres_compan'] : 'N/P' ; 
				  $item['pedres_sucurs']      = isset($item['pedres_sucurs'])? $item['pedres_sucurs'] : 'N/P' ; 
				  $item['pedres_fecped']      = isset($item['pedres_fecped'])? $item['pedres_fecped'] : 'N/P' ; 
				  $item['pedres_horped']      = isset($item['pedres_horped'])? $item['pedres_horped'] : 'N/P' ; 
				  $item['pedres_mesped']      = isset($item['pedres_mesped'])? $item['pedres_mesped'] : 'N/P' ; 
				  $item['pedres_cantid']      = isset($item['pedres_cantid'])? $item['pedres_cantid'] : 'N/P' ; 
				  $item['pedres_codigo']      = isset($item['pedres_codigo'])? $item['pedres_codigo'] : 'N/P' ; 
				  
				  $item['pedres_nompro']      = isset($item['pedres_nompro'])? $item['pedres_nompro'] : 'N/P' ; 
				  $item['pedres_bodega']      = isset($item['pedres_bodega'])? $item['pedres_bodega'] : 'N/P' ; 
				  $item['pedres_precio']      = isset($item['pedres_precio'])? $item['pedres_precio'] : 'N/P' ; 
				  $item['pedres_estado']      = isset($item['pedres_estado'])? $item['pedres_estado'] : 'N/P' ; 
				  $item['pedres_detall']      = isset($item['pedres_detall'])? $item['pedres_detall'] : 'N/P' ; 
				  $item['pedres_poriva']      = isset($item['pedres_poriva'])? $item['pedres_poriva'] : 'N/P' ; 
				  $item['pedres_catego']      = isset($item['pedres_catego'])? $item['pedres_catego'] : 'N/P' ; 
				  
				  $item['pedres_pedtou']      = isset($item['pedres_pedtou'])? $item['pedres_pedtou'] : 'N/P' ; 
				  $item['pedres_estcam']      = isset($item['pedres_estcam'])? $item['pedres_estcam'] : 'N/P' ; 
				  $item['pedres_enviaa']      = isset($item['pedres_enviaa'])? $item['pedres_enviaa'] : 'N/P' ; 
				  $item['pedres_filpad']      = isset($item['pedres_filpad'])? $item['pedres_filpad'] : 'N/P' ; 
				  $item['pedres_filnum']      = isset($item['pedres_filnum'])? $item['pedres_filnum'] : 'N/P' ; 
				  
				  $item['pedres_pventa']      = isset($item['pedres_pventa'])? $item['pedres_pventa'] : 'N/P' ; 
				  $item['pedres_mesero']      = isset($item['pedres_mesero'])? $item['pedres_mesero'] : 'N/P' ; 
				  $item['pedres_obserc']      = isset($item['pedres_obserc'])? trim($item['pedres_obserc']) : 'N/P' ; 
				  $item['pedres_origen']      = isset($item['pedres_origen'])? $item['pedres_origen'] : 'N/P' ; 
				  $item['pedres_numero']      = isset($item['pedres_numero'])? $item['pedres_numero'] : 'N/P' ; 
				  $item['pedres_cortes']      = isset($item['pedres_cortes'])? $item['pedres_cortes'] : 'N/P' ; 
				  
				  $item['pedres_admini']      = isset($item['pedres_admini'])? $item['pedres_admini'] : 'N/P' ; 
				  $item['pedres_motivo']      = isset($item['pedres_motivo'])? $item['pedres_motivo'] : 'N/P' ; 
				  $item['pedres_precue']      = isset($item['pedres_precue'])? $item['pedres_precue'] : 'N/P' ;
					
				  $item['pedres_pordes']      = isset($item['pedres_pordes'])? $item['pedres_pordes'] : 'N/P' ; 
				  $item['pedres_valdes']      = isset($item['pedres_valdes'])? $item['pedres_valdes'] : 'N/P' ; 
				  $item['pedres_anufec']      = isset($item['pedres_anufec'])? $item['pedres_anufec'] : 'N/P' ; 
				  $item['pedres_anuhor']      = isset($item['pedres_anuhor'])? $item['pedres_anuhor'] : 'N/P' ; 

 
                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("detalles" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	




    public function GuardarPedidos($data) /*** REGISTRO PEDIDO ***/
    {
        try {

            if (!isset($data['mesero'])) return Funciones::RespuestaJson(2, "Debe establecer el mesero");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
      
			$fecha_pedido = date("n/d/Y");
            $hora_pedido =  date("H:i:s");
 
            $compania = intval($data['empresa']);
            $sucursal = intval($data['sucursal']);
            $mesero   = intval($data['mesero']); 

           $sql = "INSERT INTO tb_pedtou (pedtou_compan, pedtou_sucurs, pedtou_fecped, pedtou_mesped, pedtou_horped, pedtou_estado, pedtou_ruccli,pedtou_nomcli, pedtou_numcli,pedtou_mesero, pedtou_observ)
            VALUES('$compania','$sucursal','$fecha_pedido','$mesa_braza','$hora_pedido','$estado', '$rucCliente', '$nomCliente','$numcliente','$mesero','$observacion') ";

			//echo $sql;exit();
			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo registrar el pedido!");

            $sqlt = "SELECT MAX(pedtou_pedtou) AS ultimo_id FROM tb_pedtou";
            $execid = $this->Consulta($sqlt, true);

            if (!$execid) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $ultimo_id = $execid[0]['ultimo_id'];

            return Funciones::RespuestaJson(1, "Registro exitoso!", $ultimo_id);
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }


    
    public function GuardarFacturas($data) /*** REGISTRO PEDIDO ***/
    {
        try {

            if (!isset($data['mesero'])) return Funciones::RespuestaJson(2, "Debe establecer el mesero");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
      
			$fecha_factura = date("n/d/Y");
            $hora_factura =  date("H:i:s");
 
            $compania = intval($data['empresa']);
            $sucursal = intval($data['sucursal']);
            $pedido = intval($data['pedido']); //pedido
            $mesero = intval($data['mesero']); //mesero

            $rucCliente = trim($data['rucCliente']);
            $nomCliente = trim($data['nomCliente']);
			$observacion = trim($data['observacion']);

            $sql = "INSERT INTO saepven (pedtou_compan, pedtou_sucurs, pedtou_fecped, pedtou_mesped, pedtou_horped, pedtou_estado, pedtou_ruccli,pedtou_nomcli, pedtou_numcli,pedtou_mesero, pedtou_observ)
            VALUES('$compania','$sucursal','$fecha_pedido','$mesa_braza','$hora_pedido','$estado', '$rucCliente', '$nomCliente','$numcliente','$mesero','$observacion') ";

			echo $sql;exit();
			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo registrar el pedido!");

            $sqlt = "SELECT MAX(pedtou_pedtou) AS ultimo_id FROM tb_pedtou";
            $execid = $this->Consulta($sqlt, true);

            if (!$execid) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $ultimo_id = $execid[0]['ultimo_id'];

            return Funciones::RespuestaJson(1, "Registro exitoso!", $ultimo_id);
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }


    public function GuardarDetallePedidos($data) /*** REGISTRO DETALLE PEDIDO ***/
    {
        try {

            if (!isset($data['mesero'])) return Funciones::RespuestaJson(2, "Debe establecer el mesero");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
      
			$fecha_pedido = date("n/d/Y");
            $hora_pedido =  date("H:i:s");
 
            $compania = intval($data['empresa']);
            $sucursal = intval($data['sucursal']);
            $idpedido = intval($data['idpedido']); //brazalete
            $brazalete = intval($data['idpedido']); //brazalete
            $mesero = intval($data['mesero']); //mesero

            $json_data = file_get_contents('php://input');

            // Decodificar el JSON a un array asociativo
            $data = json_decode($json_data, true);

            // Verificar si existe el arreglo 'arreglos' y si es un arreglo
            if (isset($data['arreglos']) && is_array($data['arreglos'])) {
                // Iterar sobre cada objeto dentro del arreglo 'arreglos'
                foreach ($data['arreglos'] as $objeto) {
                    // Verificar si existe la clave 'nombre' en el objeto
                    if (isset($objeto['pedres_codigo'])) {

                        $pedresCompan = $objeto['pedres_compan'];
                        $pedresSucurs = $objeto['pedres_sucurs'];
                        $pedresFecped = $fecha_pedido;
                        $pedresHorped = $hora_pedido;
                        $pedresMesped = $objeto['pedres_mesped'];
                        $pedresCantid = $objeto['pedres_cantid'];
                        $pedresCodigo = $objeto['pedres_codigo'];
                        $pedresNompro = $objeto['pedres_nompro'];
                        $pedresBodega = $objeto['pedres_bodega'];
                        $pedresPrecio = $objeto['pedres_precio'];
                        $pedresDetall = $objeto['pedres_detall'];
                        $pedresPoriva = $objeto['pedres_poriva'];
                        $pedresCatego = $objeto['pedres_catego'];
                        $pedresPedtou = $idpedido;
                        $pedresEstcam = $objeto['pedres_estcam'];
                        $pedresImpres = $objeto['pedres_impres'];
                        $pedresEnviaa = $objeto['pedres_enviaa'];
                        $pedresPventa = $objeto['pedres_pventa'];
                        $pedresMesero = $objeto['pedres_mesero'];
                        $pedresObserc = $objeto['pedres_obserc']; 

                        $sql = "INSERT INTO tb_pedres  (pedres_compan,pedres_sucurs,pedres_fecped,pedres_horped,pedres_mesped,pedres_cantid,pedres_codigo,pedres_nompro,pedres_bodega,pedres_precio,pedres_detall,pedres_poriva,pedres_catego,pedres_pedtou,pedres_estcam,pedres_impres,pedres_enviaa,pedres_pventa,pedres_mesero,pedres_obserc)
                        VALUES('$pedresCompan','$pedresSucurs', '$pedresFecped',  '$pedresHorped', '$pedresMesped',  '$pedresCantid',
                            '$pedresCodigo' , '$pedresNompro' ,'$pedresBodega',  '$pedresPrecio' , '$pedresDetall','$pedresPoriva ','$pedresCatego', '$pedresPedtou' , '$pedresEstcam' ,'$pedresImpres','$pedresEnviaa','$pedresPventa' ,'$pedresMesero','$pedresObserc') ";
        //echo  $sql;exit();
                        $exec = $this->Consulta($sql, false, true);
                        if (!$exec) return Funciones::RespuestaJson(2, "No se pudo registrar el detalle!");

                    }

       
                    return Funciones::RespuestaJson(1, "Registro exitoso!", "");
                }
            } else {
                return Funciones::RespuestaJson(2, "No se recibió un arreglo válido de pedido");
            }



        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }






    public function AnularDetallePedidos($data) /*** ANULAR PEDIDO ***/
    {
        try {

            if (!isset($data['mesero'])) return Funciones::RespuestaJson(2, "Debe establecer el mesero");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
      
			$fecha_pedido = date("n/d/Y");
            $hora_pedido =  date("H:i:s");
 
            $compania = intval($data['empresa']);
            $sucursal = intval($data['sucursal']);
            $idpedido = intval($data['idpedido']); //brazalete
            $brazalete = intval($data['idpedido']); //brazalete
            $mesero    = intval($data['mesero']); //mesero
            $iddetalle = intval($data['iddetalle']);

            $pedresAdmini = $data['pedresAdmini'];//SE LLENA CUANDO HAYA ANULACION O DESCUENTO
            $pedresMotivo = $data['pedresMotivo'];//SE LLENA CUANDO HAYA ANULACION O DESCUENTO

            $sql = "UPDATE tb_pedres SET pedres_admini = '$pedresAdmini' , pedres_motivo= '$pedresMotivo' , pedres_anufec='$fecha_pedido', pedres_estado='A',  pedres_anuhor='$hora_pedido'   WHERE pedres_pedres=' $iddetalle' ";

            $exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo Actualizar el detalle!");

            return Funciones::RespuestaJson(1, "Anulación exitosa!", $iddetalle);

        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }



    public function DescuentoDetallePedidos($data) /*** UPDATE DESCUENTO  PEDIDO ***/
    {
        try {

            if (!isset($data['mesero'])) return Funciones::RespuestaJson(2, "Debe establecer el mesero");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
      
			$fecha_pedido = date("n/d/Y");
            $hora_pedido =  date("H:i:s");
 
            $compania = intval($data['empresa']);
            $sucursal = intval($data['sucursal']);
            $idpedido = intval($data['idpedido']); //brazalete
            $brazalete = intval($data['idpedido']); //brazalete
            $mesero    = intval($data['mesero']); //mesero
            $iddetalle = intval($data['iddetalle']);

            $pedresPedtou = $idpedido;
            $pedresAdmini = $data['pedresAdmini'];//SE LLENA CUANDO HAYA ANULACION O DESCUENTO
            $pedresMotivo = $data['pedresMotivo'];//SE LLENA CUANDO HAYA ANULACION O DESCUENTO
            $pedresPordes = $data['pedresPordes'];//SE LLENA CUANDO HAYA  DESCUENTO
            $pedresValdes = $data['pedresValdes'];//SE LLENA CUANDO HAYA  DESCUENTO

            $sql = "UPDATE tb_pedres SET pedres_admini = '$pedresAdmini' , pedres_motivo= '$pedresMotivo' ,  pedres_valdes='$pedresValdes',  pedres_pordes='$pedresPordes'  WHERE pedres_pedres=' $iddetalle' ";

            $exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo Actualizar el detalle!");

            return Funciones::RespuestaJson(1, "Descuento exitoso!", $iddetalle);

        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }



    public function PrecuentaPedidos($data) /*** UPDATE PRECUENTA ***/
    {
        try {

            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
      
			$fecha_pedido = date("n/d/Y");
            $hora_pedido =  date("H:i:s");
 
            $compania = $data['empresa'];
            $sucursal = $data['sucursal'];
            $brazalete = $data['idpedido']; //brazalete

            $sql = "UPDATE tb_pedtou SET pedtou_precue = '$hora_pedido' WHERE pedtou_pedtou=' $brazalete' ";
            echo $sql;exit();
            $exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo generar la precuenta!");

            return Funciones::RespuestaJson(1, "Precuenta exitosa!", $brazalete);

        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    /*******************************    SUBIDA MASIVA DE DATOS    **************** */


    public function SubidaDetallePedidos($data) /*** SUBIDA CABECERA PEDIDO ***/
    {
        try {

            if (!isset($data['mesero'])) return Funciones::RespuestaJson(2, "Debe establecer el mesero");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
      
			$fecha_pedido = date("n/d/Y");
            $hora_pedido =  date("H:i:s");
 
            $compania = intval($data['empresa']);
            $sucursal = intval($data['sucursal']);
            $mesero   = intval($data['mesero']); //mesero

            $json_data = file_get_contents('php://input');


            $data = json_decode($json_data, true);
            $arregloDeArreglos = array();
     
            if (isset($data['arreglocabecera']) && is_array($data['arreglocabecera'])) {

                foreach ($data as $key => $value) {
                    foreach ($value as  $elemento) {
                  
                        $data_llena = array();
                        $salida = explode("-",$elemento['fecha_pedido']);
                        $salidaT = $salida[1].'/'.$salida[2].'/'.$salida[0];

                        $compania     = $elemento['compania'];
                        $sucursal     = $elemento['sucursal'];
                        $fecha_pedido = $salidaT;
                        $mesa_braza   = $elemento['mesa_braza'];
                        $hora_pedido = $elemento['hora_pedido'];
                        $estado      = $elemento['estado'];
                        $rucCliente  = $elemento['rucCliente'];
                        $nomCliente  = $elemento['nomCliente'];
                        $numcliente  = $elemento['numcliente'];
                        $mesero      = $elemento['mesero'];
                        $observacion = $elemento['observacion'];

                       // echo $compania.'-'.$sucursal.'-'.$fecha_pedido.'-'.$mesa_braza.'-'.$hora_pedido.''.$estado.''.$rucCliente.'-'.$nomCliente.'-'.$numcliente.'-'.$mesero.'-'.$observacion.'----';

                        $sql = "INSERT INTO tb_pedtou (pedtou_compan, pedtou_sucurs, pedtou_fecped, pedtou_mesped, pedtou_horped, pedtou_estado, pedtou_ruccli,pedtou_nomcli, pedtou_numcli,pedtou_mesero, pedtou_observ)
                        VALUES('$compania','$sucursal','$fecha_pedido','$mesa_braza','$hora_pedido','$estado', '$rucCliente', '$nomCliente','$numcliente','$mesero','$observacion') ";
            
                        echo $sql;
                        //$exec = $this->Consulta($sql, false, true);
                        //if (!$exec) return Funciones::RespuestaJson(2, "No se pudo registrar la cabecera!");
            
                        $sqlt = "SELECT MAX(pedtou_pedtou) AS ultimo_id FROM tb_pedtou";
                        $execid = $this->Consulta($sqlt, true);
                        if (!$execid) return Funciones::RespuestaJson(2, "No se encontro el id");

                        $data_llena = array(
                            "idPedido"   => $execid[0]['ultimo_id'],
                            "idBrazalete" => $mesa_braza
                        );

                    $arregloDeArreglos[] = $data_llena;
                }

                }
                
                return Funciones::RespuestaJson(1, "Registro exitoso!",array("idCodigo" => $arregloDeArreglos));
            } else {
                return Funciones::RespuestaJson(2, "No se recibió un arreglo válido de pedido");
            }

        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }





	public function BuscoPrecio($empresa,$sucursal,$codigo) 
    {            
            $sql = "SELECT  NVL(ppr_pre_raun, 0) AS valor_modificado  FROM saeppr where ppr_cod_empr=$empresa and ppr_cod_sucu=$sucursal AND ppr_cod_prod='$codigo'"; 

            $exec = $this->Consulta($sql, true);
		    $cantidad = '0.00';
            $items = array();
            foreach ($exec as $item) {    
                $cantidad = round($item['valor_modificado'], 2);   
            }

           // $cantidad = $exec[0]['valor_modificado']; PENDIENTE AJUSTAR 

            return  $cantidad ;
    }

    public function BuscoSecuencialFactura($empresa,$sucursal) 
    {         
            $sql = "SELECT  MAX(pven_num_pven) AS secuencia  FROM saepven where LEN(pven_num_pven) =9;"; 
            $exec = $this->Consulta($sql, true);

            $secuencia = ltrim($exec[0]['secuencia'], '0');
            $secuencia = $secuencia + 1; 
            $secuencia_final = str_pad($secuencia, 9, '0', STR_PAD_LEFT);

            return  $secuencia_final ;
    }



/********************************************************  PRODUCTOS ***********/
	public function ListarProductos($data)
    {
        try {
			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);
		
            $sql = "SELECT prbo_det_prod as categoria,prbo_iva_porc as iva, prod_cod_prod,prod_cod_empr,prod_nom_prod,prod_nom_ext,prod_fin_prod,prod_cod_colr,prod_cod_marc,prod_cod_tpro, prod_cod_medi,prod_cod_empa,prod_cod_sucu,prod_cod_linp,prod_cod_grpr,prod_cod_cate,prod_ser_prod, prod_imp_prod,prod_num_intv,prod_des_prod  from saeprod  left join saeprbo on  saeprod.prod_cod_prod = saeprbo.prbo_cod_prod where prod_cod_empr = '$empresa' and prod_cod_sucu= '$sucursal' and substr(prod_cod_prod,1,1)='P' LIMIT 1000";


            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

             $precio = $this->BuscoPrecio($empresa, $sucursal, trim($item['prod_cod_prod']));

				
			 $item['categoria'] = isset($item['categoria'])? trim($item['categoria']) : 'VARIOS' ;
			 $item['prod_cod_prod'] = isset($item['prod_cod_prod'])?  trim($item['prod_cod_prod']) :  'N/P' ;
			 $item['prod_cod_empr'] = isset($item['prod_cod_empr'])? trim($item['prod_cod_empr']) : 'N/P' ;
			 $item['prod_nom_prod'] = isset($item['prod_nom_prod'])? trim($item['prod_nom_prod']) : 'N/P' ;
			 $item['prod_nom_ext'] = isset($item['prod_nom_ext'])? trim($item['prod_nom_ext']) : 'N/P' ;
			 $item['prod_fin_prod'] = isset($item['prod_fin_prod'])? trim($item['prod_fin_prod']) : 'N/P' ;
			 $item['prod_cod_colr'] = isset($item['prod_cod_colr'])? trim($item['prod_cod_colr']) : 'N/P' ;
			 $item['prod_cod_marc'] = isset($item['prod_cod_marc'])? trim($item['prod_cod_marc']) : 'N/P' ;
			 $item['prod_cod_tpro'] = isset($item['prod_cod_tpro'])? trim($item['prod_cod_tpro']) : 'N/P' ;
			 $item['prod_cod_medi'] = isset($item['prod_cod_medi'])? trim($item['prod_cod_medi']) : 'N/P' ;
			 $item['prod_cod_empa'] = isset($item['prod_cod_empa'])? trim($item['prod_cod_empa']) : 'N/P' ;
			 $item['prod_cod_sucu'] = isset($item['prod_cod_sucu'])? trim($item['prod_cod_sucu']) : 'N/P' ;
			 $item['prod_cod_linp'] = isset($item['prod_cod_linp'])? trim($item['prod_cod_linp']) : 'N/P' ;
			 $item['prod_cod_grpr'] = isset($item['prod_cod_grpr'])? trim($item['prod_cod_grpr']) : 'N/P' ;
			 $item['prod_cod_cate'] = isset($item['prod_cod_cate'])? trim($item['prod_cod_cate']) : 'N/P' ;
			 $item['prod_ser_prod'] = isset($item['prod_ser_prod'])? trim($item['prod_ser_prod']) : 'N/P' ;
			 $item['prod_imp_prod'] = isset($item['prod_imp_prod'])? trim($item['prod_imp_prod']) : 'N/P' ;
			 $item['prod_num_intv'] = isset($item['prod_num_intv'])? trim($item['prod_num_intv']) : 'N/P' ;
			 $item['prod_des_prod'] = isset($item['prod_des_prod'])? trim($item['prod_des_prod']) : 'N/P' ;
			 $item['precio'] =  strval($precio) ;
			 $item['iva'] =  strval($item['iva']);


                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "Busqueda exitosa!", array("productos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }



	public function ListarCategorias($data)
    {
        try {
			
			$sucursal = trim($data['sucursal']);
			$empresa = trim($data['empresa']);

            $sql = "SELECT lcat_cod_lcat,lcat_cod_empr,lcat_cod_sucu,lcat_nom_cate,lcat_chk_lcat,lcat_bod_lcat,lcat_tip_lcat,lcat_imp_dbar 
                    FROM saelcat where lcat_cod_empr = '$empresa'  AND lcat_cod_sucu= '$sucursal'  AND lcat_tip_lcat in (1,2) order by  lcat_nom_cate desc ;  ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            foreach ($exec as $item) {

            $item['lcat_cod_lcat'] = isset($item['lcat_cod_lcat'])? $item['lcat_cod_lcat'] : 'N/P' ;
			$item['lcat_cod_empr'] = isset($item['lcat_cod_empr'])? $item['lcat_cod_empr'] : 'N/P' ;
			$item['lcat_cod_sucu'] = isset($item['lcat_cod_sucu'])? $item['lcat_cod_sucu'] : 'N/P' ;
			$item['lcat_nom_cate'] = isset($item['lcat_nom_cate'])? $item['lcat_nom_cate'] : 'N/P' ;
			$item['lcat_chk_lcat'] = isset($item['lcat_chk_lcat'])? $item['lcat_chk_lcat'] : 'N/P' ;
			$item['lcat_bod_lcat'] = isset($item['lcat_bod_lcat'])? $item['lcat_bod_lcat'] : 'N/P' ;
			$item['lcat_tip_lcat'] = isset($item['lcat_tip_lcat'])? $item['lcat_tip_lcat'] : 'N/P' ;
			$item['lcat_imp_dbar'] = isset($item['lcat_imp_dbar'])? $item['lcat_imp_dbar'] : 'N/P' ;
			 
            $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "Busqueda exitosa!", array("categorias" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }




/*********************************FACTURA******************************FACTURA */





public function  BuscarFacturas($data)
{
    try {

        $sucursal = trim($data['sucursal']);
        $empresa = trim($data['empresa']);

       // $sql = "SELECT * FROM  saedpve where  pven_cod_empr=2  and  pven_cod_sucu=926 order by dpve_cod_dpve desc  limit 10;";
        $sql = "SELECT * FROM saepven where pven_cod_empr = 2 and pven_cod_sucu = 926 order by pven_cod_pven desc  limit 100; ";
        $exec = $this->Consulta($sql, true);

        if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

        $items = array();

        foreach ($exec as $item) {

            $items[] = $item;
        }

        return Funciones::RespuestaJson(1, "", array("facturas" => $items));
    } catch (Exception $e) {
        Funciones::Logs(basename(__FILE__, '.php'), $e);
        return Funciones::RespuestaJson(2, "Error de servidor interno");
    }
}




public function  BuscarFormasPagos($data)
{
    try {

        $sucursal = trim($data['sucursal']);
        $empresa = trim($data['empresa']);


        $sql = "SELECT fpag_cod_fpag,fpag_sig_fpag,fpag_des_fpag FROM SAEfpag where  fpag_cod_empr='$empresa'";
        $exec = $this->Consulta($sql, true);

        if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

        $items = array();

        foreach ($exec as $item) {

            $items[] = $item;
        }

        return Funciones::RespuestaJson(1, "", array("formas" => $items));
    } catch (Exception $e) {
        Funciones::Logs(basename(__FILE__, '.php'), $e);
        return Funciones::RespuestaJson(2, "Error de servidor interno");
    }
}





/************************    FACTURAS REGISTRO********************************* */


public function GuardarFacturaCabecera($data) /*** REGISTRO PEDIDO ***/
{
    try {

        if (!isset($data['mesero'])) return Funciones::RespuestaJson(2, "Debe establecer el mesero");
        if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
        if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");
  
        $fecha_pedido = date("n/d/Y");
        $hora_pedido =  date("H:i:s");

        $compania = intval($data['empresa']);
        $sucursal = intval($data['sucursal']);
        $mesero = intval($data['mesero']); //mesero

          $mesa_braza = trim($data['mesped']); //brazalete
        $estado = trim($data['estado']); //trim($data['estado']);
        $numcliente = trim($data['numclientes']); //numero de clientes en mesa  = 1
        $rucCliente = trim($data['rucCliente']);
        $nomCliente = trim($data['nomCliente']);
        $observacion = trim($data['observacion']);

        $sql = "INSERT INTO tb_pedtou (pedtou_compan, pedtou_sucurs, pedtou_fecped, pedtou_mesped, pedtou_horped, pedtou_estado, pedtou_ruccli,pedtou_nomcli, pedtou_numcli,pedtou_mesero, pedtou_observ)
        VALUES('$compania','$sucursal','$fecha_pedido','$mesa_braza','$hora_pedido','$estado', '$rucCliente', '$nomCliente','$numcliente','$mesero','$observacion') ";

        //echo $sql;exit();
        $exec = $this->Consulta($sql, false, true);
        if (!$exec) return Funciones::RespuestaJson(2, "No se pudo registrar el pedido!");

        $sqlt = "SELECT MAX(pedtou_pedtou) AS ultimo_id FROM tb_pedtou";
        $execid = $this->Consulta($sqlt, true);

        if (!$execid) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

        $ultimo_id = $execid[0]['ultimo_id'];

        return Funciones::RespuestaJson(1, "Registro exitoso!", $ultimo_id);
    } catch (Exception $e) {
        Funciones::Logs(basename(__FILE__, '.php'), $e);
        return Funciones::RespuestaJson(2, "Error de servidor interno");
    }
}


public function RegistroDetallePFactura($empresa,$sucursal,$idpedido,$idfactura) // REGISTRO DETALLE FACTURA 
{
    try {
        
        $sucursal = $data['sucursal'];
        $empresa  = $data['empresa'];
        $idpedido = $data['idpedido'];
        
        $sql = " SELECT    pedres_compan,pedres_sucurs,pedres_fecped,pedres_horped,pedres_mesped,pedres_cantid,pedres_codigo,pedres_nompro,pedres_bodega,pedres_precio,pedres_detall,pedres_poriva,pedres_catego,pedres_pedtou,pedres_estcam,pedres_impres,pedres_enviaa,pedres_pventa,pedres_mesero,pedres_obserc
        FROM tb_pedres  WHERE pedres_compan = '$empresa' AND pedres_sucurs= '$sucursal' AND pedres_pedtou= '$idpedido' ";

        $exec = $this->Consulta($sql, true);

        if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

        $items = array();

        foreach ($exec as $item) {

            $pedresCompan = $item['pedres_compan'];
            $pedresSucurs = $item['pedres_sucurs'];
            $pedresCodigo = $item['pedres_codigo'];
            $pedresCantid = $item['pedres_cantid'];
            $pedresPrecio = $item['pedres_precio'];
            $pedresPoriva = $item['pedres_poriva'];
            $dpveDsgDpve = '0.00';
            $pedresNompro = $item['pedres_nompro'];

            $sql ="INSERT INTO saedpve (ven_cod_pven,pven_cod_empr,pven_cod_sucu,prbo_cod_prod,dpve_can_dpve,dpve_pre_dpve,
                                    dpve_iva_dpve,dpve_dsg_dpve,dpve_cm3_vari)
                        VALUES('$iFactura','$pedresCompan','$pedresSucurs','$pedresCodigo',
                        '$pedresCantid','$pedresPrecio','$pedresPoriva','$dpveDsgDpve','$pedresNompro')";
            echo $sql;

        }
        exit();
        return Funciones::RespuestaJson(1, "", array("detalles" => $items));
    } catch (Exception $e) {
        Funciones::Logs(basename(__FILE__, '.php'), $e);
        return Funciones::RespuestaJson(2, "Error de servidor interno");
    }
}



	
}
