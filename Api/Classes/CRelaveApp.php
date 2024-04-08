<?php

class Relaves extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }

    public function Listar_Habitacion($data)
    {
        try {
            $sucursal = intval($data['sucursalToken']) == 0 ? 0 : intval($data['sucursalToken']);

            $sql = "SELECT habi_cod_habi, habi_cod_sucu, habi_cod_char, habi_nom_habi 
            FROM saehabi 
            WHERE habi_cod_sucu = (
                SELECT SUCURS_CODHOT 
                FROM tb_sucurs 
                WHERE sucurs_sucurs = $sucursal
            )
            AND NOT SUBSTR(  habi_cod_char, 1, 1 ) IN ('C', 'E', 'R', 'V')";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar", $sql);

            $items = $exec;

            return Funciones::RespuestaJson(1, "", array("habitaciones" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Listar($data)
    {
        try {
            
            $sucursal = intval($data['sucursalToken']) == 0 ? 0 : intval($data['sucursalToken']);
			//$sucursal = intval($data['sucursal']) == 0 ? 0 : intval($data['sucursal']);

            $sql = "SELECT * FROM TB_RELHOT WHERE RELHOT_SUCURS in ( 
                SELECT sucurs_codhot FROM tb_sucurs WHERE sucurs_sucurs = $sucursal ) and  RELHOT_ESTADO = 'I' ";

           $exec = $this->Consulta($sql, true);
           // muestra error 
            // if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar $sql", array($sql));
            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay relavos para mostrar ", array($sql));

            $items = array();

            foreach ($exec as $item) {

                $relave['relave_relave'] = intval($item['relhot_relhot']);
                $relave['relave_tiplen'] = $item['relhot_codlen'];
                $relave['relave_codmot'] = $item['relhot_codmot'];
                $relave['relave_obsini'] = html_entity_decode($item['relhot_obsini']);
                $relave['relave_momlen'] = $item['relhot_nomlen'];
				$relave['relave_codala'] = $item['relhot_codala'];
                $relave['relave_fehoin'] = date("d-m-Y H:i", strtotime($item['relhot_fecini'] . " " . $item['relhot_horini']));

                $items[] = $relave;
            }

            return Funciones::RespuestaJson(1, "", array("relaves" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Listar_Lenceria($data)
    {
        try {
            //$sucursal = !isset($data['sucursalToken']) ? 0 : intval($data['sucursalToken']);

            // $sqlLenceria = "SELECT TIPPRE_TIPPRE, TIPPRE_CODIGO, TIPPRE_NOMBRE FROM TB_TIPPRE WHERE TIPPRE_TIPLAV = 'HOTEL'";


            $sqlLenceria = "SELECT * FROM SAEREPI WHERE REPI_TIP_REPI = 39 ORDER BY REPI_COD_BODE";

            $exec = $this->Consulta($sqlLenceria, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();
			$lenceria['tippre_codigo'] = "0";
            $lenceria['tippre_nombre'] = "SELECCIONE";
			$items[] = $lenceria;
            foreach ($exec as $item) {

                $lenceria['tippre_codigo'] = $item['repi_cod_repi'];
                $lenceria['tippre_nombre'] = $item['repi_nom_prod'];

                $items[] = $lenceria;
            }


            return Funciones::RespuestaJson(1, "", array("lenceria" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Listar_Motivo()
    {
        try {
            $sqlMotivo = "SELECT * FROM SAELETI WHERE LETI_COD_CHAR > 4 AND LETI_TIP_LETI = 1 ORDER BY LETI_COD_CHAR";

            $exec = $this->Consulta($sqlMotivo, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();
			$itemResult['motapp_motapp'] = "0";
			$itemResult['motapp_nombre'] = "SELECCIONE";

			$items[] = $itemResult;

            foreach ($exec as $item) {

                $itemResult['motapp_motapp'] = $item['leti_cod_leti'];
                $itemResult['motapp_nombre'] = $item['leti_des_leti'];

                $items[] = $itemResult;
            }

            return Funciones::RespuestaJson(1, "", array("motivos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Listar_Alas($data)
    {
        try {
            $sucursal = intval($data['sucursal']) == 0 ? 0 : intval($data['sucursal']);

            $sqlAlas = "SELECT alas_cod_alas,alas_des_alas FROM SAEALAS WHERE ALAS_COD_SUCU = (
                SELECT sucurs_codhot FROM tb_sucurs WHERE sucurs_sucurs = $sucursal
            ) AND NOT ALAS_DES_ALAS = 'OCASIONAL'";

            // CPON TRUE PARA QUE TRAIGA TODOS LOS ELEMENTOS DE LA CONSULTA
            $exec = $this->Consulta($sqlAlas, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();
			
			$itemResult['alas_cod_alas'] = "0";
			$itemResult['alas_des_alas'] = "SELECCIONE";

			$items[] = $itemResult;
			
            foreach ($exec as $item) {
				
				$itemResult['alas_cod_alas'] = $item['alas_cod_alas'];
                $itemResult['alas_des_alas'] = $item['alas_des_alas'];
				
                $items[] = $itemResult;
            }

            return Funciones::RespuestaJson(1, "", array("alas" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	
	
	
	
	
	
	/******    NUEVO DESARROLLO  pendiente por ajustar listar****/
	public function ListarApp($data)
    {
        try {
            
            //$sucursal = intval($data['sucursalToken']) == 0 ? 0 : intval($data['sucursalToken']);
			$sucursal = intval($data['sucursal']);

            $sql = "SELECT * FROM TB_RELHOT WHERE RELHOT_SUCURS in ( 
                SELECT sucurs_codhot FROM tb_sucurs WHERE sucurs_sucurs = $sucursal ) and  RELHOT_ESTADO = 'I' ORDER BY relhot_relhot DESC";

           $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay relavos para mostrar ", array($sql));

            $items = array();

            foreach ($exec as $item) {

                $relave['relave_relave'] = intval($item['relhot_relhot']);
                $relave['relave_tiplen'] = $item['relhot_codlen'];
                $relave['relave_codmot'] = $item['relhot_codmot'];
                $relave['relave_obsini'] = html_entity_decode($item['relhot_obsini']);
                $relave['relave_momlen'] = $item['relhot_nomlen'];
				$relave['relave_codala'] = $item['relhot_codala'];
				$relave['supervisor']    = $this->Supervisor($item['relhot_supini']);
                $relave['relave_fehoin'] = date("d-m-Y H:i", strtotime($item['relhot_fecini'] . " " . $item['relhot_horini']));

                $items[] = $relave;
            }

            return Funciones::RespuestaJson(1, "", array("relaves" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
	public function Supervisor($data)
    {            

            $sql = "SELECT * FROM SAEEMPL WHERE EMPL_COD_EMPL = $data  limit 1 ";
            $exec = $this->Consulta($sql, true);
		   
            $items = array();
            foreach ($exec as $item) {    
                $relave = $item['empl_ape_empl'];  
            }

            return $relave;
    }
	

    public function Guardar($data, $files)
    {
        try {
			
			$superv = '8888888888';//trim($data['supervisor']);
			$camarera = isset($data['camarera']) ?  trim($data['camarera']) : "";
			$observacion = htmlentities(trim($data['observacion']));
			$codLenc = trim($data['codigoLenceria']);
            $nomLenc = trim($data['nombreLenceria']);
            $codmotivo = trim($data['codigoMotivo']);
            $nomMotivo = trim($data['nombreMotivo']);
			$codAla = intval(($data['codigoAla']));
		
			$sucursal = intval($data['sucursal']);

			$totFil = intval($data['total']);

            $date = date("Y/m/d");
			$date2 = date("n/d/Y");
			$date3 = date("m-d-Y");
			$date4 = date("d-m-Y");
			$time = date("H:i:s");
            $os = php_uname();
			

            $sqlTurno = "SELECT TURN.PLTU_COD_PLTU, SUCURS.sucurs_codhot FROM saepltu AS TURN
            INNER JOIN tb_sucurs AS SUCURS
            ON TURN.pltu_cod_sucu = SUCURS.sucurs_codhot
            WHERE pltu_fech_pltu = today
            AND pltu_casu_motu = 'CA' 
            AND pltu_fech_pltu = pltu_fech_hast 
            AND SUCURS.sucurs_sucurs = $sucursal";

            $exec = $this->Consulta($sqlTurno);

            if (!$exec) Funciones::Logs(basename(__FILE__, '.php'), "ERROR AL OBTENER EL TURNO DE INICIO => $sqlTurno");
			
			$cod_turno = intval($exec['pltu_cod_pltu']);
            $sucHot = intval($exec['sucurs_codhot']);//'$superv'
			
			
			$sql = "INSERT INTO tb_relhot ( relhot_turini, relhot_obsini, relhot_sucurs, relhot_supini, relhot_camini, relhot_codlen, relhot_nomlen, relhot_codmot, relhot_nommot, relhot_fecini, relhot_horini ,relhot_codAla )
                                        VALUES ( $cod_turno, '$observacion', $sucHot, '8888888888', '$camarera', '$codLenc', '$nomLenc', '$codmotivo', '$nomMotivo', '$date2', '$time' , '$codAla')";
		
            $exec = $this->Consulta($sql, false, true);

            if (!$exec) return Funciones::RespuestaJson(2, "ERROR AL REGISTRAR DATOS");
			
			
			$sqlmaxid = "select max(relhot_relhot) AS id_relave from tb_relhot";

            $exec1 = $this->Consulta($sqlmaxid);

            if (!$exec1) Funciones::Logs(basename(__FILE__, '.php'), "ERROR AL OBTENER EL TURNO DE INICIO => $sqlmaxid");
			
			$id_relave = intval($exec1['id_relave']);
			
			$root = "";
			$root = "C:/Archivos/RELAVES/$sucursal/$date/ordentrabajo/$id_relave";
			if (!file_exists($root)){
				mkdir($root, 777, true);
			}
			$files = $files;
            $totsave = 0;
            $net = 0;
            $hostServer = ":" . $_SERVER['SERVER_PORT'];
            $rootPath = str_replace("C:/../", "", $root);

            $hostServer = $hostServer . "/$rootPath";
			$countfiles = $totFil;
			
			
			if(isset($_FILES['imagen'])){
				
				$tmp_name_array = $_FILES['imagen']['tmp_name'];
				$name_array     = $_FILES['imagen']['name'];
				$archivos       = $_FILES['imagen'];
			
				if($_FILES){
					
					for ($i = 0; $i < count($archivos["name"]); $i++) {
						$nombreArchivo = $archivos["name"][$i];
						
						if (move_uploaded_file($archivos['tmp_name'][$i],  "$root/$nombreArchivo")) {
							
						 chmod("$root/$nombreArchivo", 0777);
						
						$sql = "INSERT INTO tb_manevi (manevi_manten, manevi_nomfil, manevi_dirfil, manevi_feccre, manevi_horcre) 
						VALUES  ( '$id_relave', '$nombreArchivo', '$hostServer/$nombreArchivo', '$date2', '$time' ) ";

							$exec = $this->Consulta($sql, false, true);

						if (!$exec) return Funciones::RespuestaJson(2, "Error al registrar evidencia");

							$totsave++;
							
						} else {
							$net++;
						}
					
					}
				}
			}



            return Funciones::RespuestaJson(1, "REGISTRO CON ÉXITO", $exec);
			

            
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Finalizar($data, $files)
    {
        try {
            $super = '8888888888';//trim($data['supervisor']);
            $relave = intval($data['relave']);
            $observa = htmlentities(trim($data['observacion']));
			$sucursal = intval($data['sucursal']) == 0 ? 0 : intval($data['sucursal']);
			$manten = intval($data['relave']);
            $date = date("Y/m/d");
            $time = date("H:i:s");
			$root = "";
			$root = "C:/Archivos/RELAVES/$sucursal/$date/ordentrabajo/$manten";
			$totFil = intval($data['total']);

            $tipdoc = strtolower($data['tipo_doc']);
            
            
			$date2 = date("n/d/Y");
			$date3 = date("m-d-Y");
			$date4 = date("d-m-Y");
			$date5 = date("d/n/Y");
            $os = php_uname();
            
			if (!file_exists($root)){
				mkdir($root, 777, true);
			}
			$files = $files;
            $totsave = 0;
            $net = 0;
            $hostServer = ":" . $_SERVER['SERVER_PORT'];
            $rootPath = str_replace("C:/../", "", $root);

            $hostServer = $hostServer . "/$rootPath";
			$countfiles = $totFil;
			$camarera ='';

            $sqlTurno = "SELECT PLTU_COD_PLTU , PLTU_COD_SUCU FROM saepltu WHERE pltu_fech_pltu = today AND pltu_cod_sucu = ( SELECT SUCURS_CODHOT 
            FROM tb_sucurs 
            WHERE sucurs_sucurs = $sucursal )  AND pltu_casu_motu = 'CA' AND pltu_fech_pltu <> pltu_fech_hast";

            $execS = $this->Consulta($sqlTurno);

            if (!$execS) Funciones::Logs(basename(__FILE__, '.php'), "ERROR AL OBTENER EL TURNO DE FIN => $sqlTurno");
			
			if(isset($_FILES['imagen'])){
				
				$tmp_name_array = $_FILES['imagen']['tmp_name'];
				$name_array     = $_FILES['imagen']['name'];
				$archivos       = $_FILES['imagen'];
			
				if($_FILES){
					
					for ($i = 0; $i < count($archivos["name"]); $i++) {
						$nombreArchivo = $archivos["name"][$i];
						
						if (move_uploaded_file($archivos['tmp_name'][$i],  "$root/$nombreArchivo")) {
							
						 chmod("$root/$nombreArchivo", 0777);
						
						$sql = "INSERT INTO tb_manevi (manevi_manten, manevi_nomfil, manevi_dirfil, manevi_feccre, manevi_horcre) 
						VALUES  ( '$manten', '$nombreArchivo', '$hostServer/$nombreArchivo', '$date2', '$time' ) ";

							$exec = $this->Consulta($sql, false, true);

						if (!$exec) return Funciones::RespuestaJson(2, "Error al registrar evidencia");

							$totsave++;
							
						} else {
							$net++;
						}
					
					}
				}
			}
			

            $cod_turno = intval($execS['pltu_cod_pltu']);
            $sucHot = intval($execS['pltu_cod_sucu']);


			
			$sql = "UPDATE TB_RELHOT SET relhot_turfin = $cod_turno, RELHOT_ESTADO = 'F', relhot_supfin = '$super', relhot_camfin = '$camarera', relhot_obsfin = '$observa', relhot_fecfin = '$date2', relhot_horfin = '$time' WHERE relhot_relhot = $relave AND relhot_sucurs = $sucHot";

            $exec = $this->Consulta($sql, false, true);

            if (!$exec) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR DATOS");

            return Funciones::RespuestaJson(1, "FINALIZADO CON ÉXITO");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }


}