<?php

class Productos extends DBConexion   // PROCESOS PARA EL APLICATIVO DE BUHO MARKET 
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }
	
		/******    PARA PASAR CUANDO ESTE LISTA EL API APP PEDIDOS  ******/
	
	public function Loggin($data)
    {
        try {
            if (!isset($data['usuario'])) return Funciones::RespuestaJson(2, "Debe establecer el usuario");

            $usuario = strtoupper(trim($data['usuario'])) ;

            $sql = "SELECT usua_nom_usua,usua_cod_usua FROM saeusua WHERE usua_nom_usua='$usuario'";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "No existe colaborador con el usuario '$usuario'");

            $token['usuario'] = strval($exec['usua_nom_usua']);
            $token['idusuario'] = strval($exec['usua_cod_usua']);

            return Funciones::RespuestaJson(1, "", array("usuariodata" => $token));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	

    public function GuardarProducto($data)
    {
        try {
            if (empty($data['cantidad'])) return Funciones::RespuestaJson(2, "El campo cantidad es requerido!");
            if (empty($data['idproducto'])) return Funciones::RespuestaJson(2, "Debe seleccionar un producto!");
			
            $idusuario     = intval($data['idusuario']);
			$empresaId     = 594 ;
			$sucursalId    = 928;
			$idproducto    = strval($data['idproducto']);
			$cantidad      = intval($data['cantidad']);
			$cod_infi      = 2819; //2819 2744
			$nom_producto  = $data['nom_producto'];
			$cod_barra     = $data['cod_barra'];
			$stock         = intval($data['stock']);
			$canajust      = $cantidad - $stock;
             $sql = "INSERT INTO saedifi (
											difi_cod_empr,
											difi_cod_sucu,
											difi_cod_prod,
											difi_sto_cort,
											difi_con_fisi,
											difi_cod_infi,
											difi_nom_prod,
											difi_num_lote,
											difi_dat_var2,
											difi_can_ajus
											)
								VALUES ($empresaId ,$sucursalId ,'$idproducto','$stock','$cantidad','$cod_infi','$nom_producto','$cod_barra','$idusuario','$canajust')"; 

			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No se pudo registrar");

            return Funciones::RespuestaJson(1, "Registro exitoso");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	



}