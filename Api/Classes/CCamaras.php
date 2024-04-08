<?php

class Camaras extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }
			/**** LISTADO DE CAMARAS ***/
	public function ListarCamaras($data)
    {
        try {
			ini_set("default_charset", "UTF-8");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");
			if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");

            $empresa = trim($data['empresa']);
			$sucursal = trim($data['sucursal']);
			//$fechaFilter = trim($data['fechaFilter']);act_fec_regi

            $sql = "SELECT NVL(tact_cod_tact,0) AS tact_cod_tact ,act_cod_empr ,act_cod_sucu ,sgac_cod_sgac ,eact_cod_eact ,NVL(eact_cod_eact,0) AS eact_cod_eact  ,act_nom_act ,
					 NVL(act_marc_act,0) AS act_marc_act   ,act_colr_act ,NVL(act_seri_act,0) AS act_seri_act   ,NVL(act_mode_act,0) AS act_mode_act   ,act_fcmp_act ,
					NVL(act_refr_act,0)  AS act_refr_act,act_vutil_act ,act_vres_act ,act_cant_act ,tdep_cod_tdep ,gact_cod_gact ,NVL(act_prov_act,0) AS act_prov_act   ,act_fdep_act ,
					act_ext_act ,act_nom_prop ,act_cod_ubac ,act_cod_tiac ,act_cm2_act ,act_cm3_act ,
					act_ubi_act,NVL(act_usua_act,0) AS act_usua_act ,NVL(act_fec_regi,0) AS act_fec_regi FROM saeact WHERE act_nom_act LIKE '%CAMARA%' and act_cod_sucu = $sucursal " ;
			//echo $sql ;

            $exec = $this->Consulta($sql, true);
            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");
            $items = array();

            foreach ($exec as $item) {

				 $item['tact_cod_tact'] = isset($item['tact_cod_tact']) ? trim($item['tact_cod_tact']) : 'N/P';
				 $item['act_cod_empr'] = isset($item['act_cod_empr']) ? trim($item['act_cod_empr']) : 'N/P';
				 $item['act_cod_sucu'] = isset($item['act_cod_sucu']) ? trim($item['act_cod_sucu']) : 'N/P';
				 $item['sgac_cod_sgac'] = isset($item['sgac_cod_sgac']) ? trim($item['sgac_cod_sgac']) : 'N/P';
				 $item['eact_cod_eact'] = isset($item['eact_cod_eact']) ? trim($item['eact_cod_eact']) : 'N/P';
				 $item['act_clave_act'] = isset($item['act_clave_act']) ? trim($item['act_clave_act']) : 'N/P';
				 $item['act_nom_act'] = isset($item['act_nom_act']) ? trim($item['act_nom_act']) : 'N/P';
				 $item['act_marc_act'] = isset($item['act_marc_act']) ? trim($item['act_marc_act']) : 'N/P';
				 $item['act_colr_act'] = isset($item['act_colr_act']) ? trim($item['act_colr_act']) : 'N/P';
				 $item['act_seri_act'] = isset($item['act_seri_act']) ? trim($item['act_seri_act']) : 'N/P';
				 $item['act_mode_act'] = isset($item['act_mode_act']) ? trim($item['act_mode_act']) : 'N/P';
				 $item['act_fcmp_act'] = isset($item['act_fcmp_act']) ? trim($item['act_fcmp_act']) : 'N/P';
				 $item['act_refr_act'] = isset($item['act_refr_act']) ? trim($item['act_refr_act']) : 'N/P';
				 $item['act_vutil_act'] = isset($item['act_vutil_act']) ? trim($item['act_vutil_act']) : 'N/P';
				 $item['act_vres_act'] = isset($item['act_vres_act']) ? trim($item['act_vres_act']) : 'N/P';
				 $item['act_cant_act'] = isset($item['act_cant_act']) ? trim($item['act_cant_act']) : 'N/P';
				 $item['tdep_cod_tdep'] = isset($item['tdep_cod_tdep']) ? trim($item['tdep_cod_tdep']) : 'N/P';
				 $item['gact_cod_gact'] = isset($item['gact_cod_gact']) ? trim($item['gact_cod_gact']) : 'N/P';
				 $item['act_prov_act'] = isset($item['act_prov_act']) ? trim($item['act_prov_act']) : 'N/P';
				 $item['act_fdep_act'] = isset($item['act_fdep_act']) ? trim($item['act_fdep_act']) : 'N/P';
				 $item['act_ext_act'] = isset($item['act_ext_act']) ? trim($item['act_ext_act']) : 'N/P';
				 $item['act_nom_prop'] = isset($item['act_nom_prop']) ? trim($item['act_nom_prop']) : 'N/P';
				 $item['act_cod_ubac'] = isset($item['act_cod_ubac']) ? trim($item['act_cod_ubac']) : 'N/P';
				 $item['act_ob1_act']  = isset($item['act_ob1_act']) ? trim($item['act_ob1_act']) : 'N/P';
				 $item['act_cod_tiac'] = isset($item['act_cod_tiac']) ? trim($item['act_cod_tiac']) : 'N/P';
				 $item['act_cm2_act'] = isset($item['act_cm2_act']) ? trim($item['act_cm2_act']) : 'N/P';
				 $item['act_cm3_act'] = isset($item['act_cm3_act']) ? trim($item['act_cm3_act']) : 'N/P';
				 $item['act_usua_act'] = isset($item['act_usua_act']) ? trim($item['act_usua_act']) : 'N/P';
				 $item['act_fec_regi'] = isset($item['act_fec_regi']) ? trim($item['act_fec_regi']) : 'N/P'; 
				
                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "Busqueda exitosa!", array("camaras" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function GuardarCamaras($data)
    {
        try {
            if (empty($data['empresaId'])) return Funciones::RespuestaJson(2, "Debe seleccionar un cliente!");

			$empresaId    = intval(trim($data['empresaId']));
			$sucursalId    = intval($data['sucursalId']);
            /*$sucursalIdRegister  = trim($data['sucursalIdRegister']);
            $habitacion  = strval($data['habitacion']);
			$usuarioId  = intval($data['usuarioId']);
			$nombreCli  = strval(trim($data['nombreCli']));
			$selectedType  = trim($data['selectedType']);
			$selectedAdap  = trim($data['selectedAdap']);
			$date = date("n/d/Y");
            $time = trim(date("H:i:s")); */
			
             $sql = "INSERT INTO saeact ( act_marc_act,act_nom_act,act_cod_empr,act_cod_sucu ) VALUES ('PRUEBA ', ' PRUEBA 1',$empresaId ,$sucursalId )"; 

			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            return Funciones::RespuestaJson(1, "Registro exitoso!", $data);
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	
	


}