<?php

class Visitas extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }
			/**** LISTADO DE VISITAS ***/
	public function ListarV($data)
    {
        try {
			ini_set("default_charset", "UTF-8");
            if (!isset($data['empresa'])) return Funciones::RespuestaJson(2, "Debe establecer la empresa");

            $empresa = trim($data['empresa']);
			$fechaFilter = trim($data['fechaFilter']);

            $sql = "SELECT a.viscli_viscli,a.viscli_horreg as time,a.viscli_obser1,a.viscli_clpvco,a.viscli_nomemp,a.viscli_fecreg,a.viscli_estado,
							a.viscli_ubicac,b.clpv_nom_clpv as nombre_cli,a.viscli_clpvno,a.viscli_emplru
					FROM  tb_viscli a 
					LEFT JOIN saeclpv b  ON a.viscli_clpvco  =  b.clpv_cod_clpv
					WHERE a.viscli_empres = '$empresa' and a.viscli_fecreg = '$fechaFilter' ORDER BY viscli_horreg DESC" ;

            $exec = $this->Consulta($sql, true);
            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");
            $items = array();

            foreach ($exec as $item) {

				$item['nombre_emp'] = trim($item['viscli_nomemp']);
				$item['viscli_emplru'] = trim($item['viscli_emplru']);
				$item['time'] = isset($item['time'])? $item['time'] : 'N/P' ;
				$item['viscli_clpvco'] = isset($item['viscli_clpvco']) ? trim($item['viscli_clpvco']) : 'N/P'; //codigoCliente
				$item['ubicacion'] = trim($item['viscli_ubicac']);
				$item['nombre_cli'] = isset($item['nombre_cli']) ? trim($item['nombre_cli']) : 'N/P';
				$item['nombreCliente'] = $item['viscli_clpvno']? trim($item['viscli_clpvno']): 'N/P';
				$item['observacion'] = isset($item['viscli_obser1']) ? trim($item['viscli_obser1']): 'No Posee';
				$item['estado']  = trim($item['viscli_estado']);
                $item['fechaCreacion'] = date("Y-m-d H:i", strtotime($item['viscli_fecreg'] . " " . $item['time']));

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("visitas" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Guardarv($data)
    {
        try {
            if (empty($data['nombreCli'])) return Funciones::RespuestaJson(2, "El campo cliente es requerido!");
            if (empty($data['observacion'])) return Funciones::RespuestaJson(2, "Debe escribir una observación!");
			
            $clienteId = intval($data['clienteId']);
			$phone    = strval($data['phone']);
			$empresaId    = intval(trim($data['empresaId']));
			$sucursalId    = intval($data['sucursalId']);
            $observacion  = trim($data['observacion']);
            $coordenadas  = strval($data['coordenadas']);
			$usuarioId  = intval($data['usuarioId']);
			$nombreCli  = $data['nombreCli'];
			$codigoVend  = trim($data['codigoVend']);
			$clienteRuc  = trim($data['clienteRuc']);
			$date = date("n/d/Y");
            $time = trim(date("H:i:s"));
			

             $sql = "INSERT INTO tb_viscli (
											viscli_empres,
											viscli_sucurs,
											viscli_clpvco,
											viscli_clpvno,
											viscli_ubicac,
											viscli_emplru,
											viscli_nomemp,
											viscli_obser1,
											viscli_vencod,
											viscli_usuari,
											viscli_fecreg,
											viscli_horreg,
											viscli_celula,
											viscli_estado
											)
VALUES ($empresaId ,$sucursalId , $clienteId ,'$nombreCli','$coordenadas','$clienteRuc','$nombreCli','$observacion','$codigoVend',$usuarioId,'$date','$time','$phone',1)"; 




			$exec = $this->Consulta($sql, false, true);
            if (!$exec) return Funciones::RespuestaJson(2, "No hay datos para mostrar");
unset($data['phone']);
            return Funciones::RespuestaJson(1, "Registro exitoso!", $data);
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	
	


}