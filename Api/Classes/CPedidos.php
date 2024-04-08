<?php

class Mantenimiento extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }

	public function ListarApp($data)
    {
        try {
            if (!isset($data['idusuario'])) return Funciones::RespuestaJson(2, "Debe establecer el idusuario");

            $usuario = trim($data['idusuario']);

            $sql = "SELECT *
                FROM tb_manten 
                WHERE manten_usucar = '$usuario'
                AND manten_estado <> 'FINALIZADO'
            ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            $fechaActual = new DateTime(date("Y-m-d"));

            foreach ($exec as $item) {

                $llenado = "N";

                if ($item['manten_recome'] != "") $llenado = "S";
                $item['manten_coment'] = trim($item['manten_coment']);
                $item['manten_recllen'] = $llenado;
                $fechaCreacion = new DateTime(date("Y-m-d", strtotime($item['manten_feccre'] . " " . $item['manten_horcre'])));
                $intervalo = $fechaCreacion->diff($fechaActual);
                $item['condicion'] = ($intervalo->days);
                $item['manten_feccre'] = date("Y-m-d H:i", strtotime($item['manten_feccre'] . " " . $item['manten_horcre']));

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("mantenimientos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

	public function ListarAppf($data)
    {
        try {
            if (!isset($data['idusuario'])) return Funciones::RespuestaJson(2, "Debe establecer el idusuario");

            $usuario = trim($data['idusuario']);

            $sql = "SELECT *
                FROM tb_manten 
                WHERE manten_usucar = '$usuario'
                AND manten_estado = 'FINALIZADO'
            ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            $fechaActual = new DateTime(date("Y-m-d"));

            foreach ($exec as $item) {

                $llenado = "N";

                if ($item['manten_recome'] != "") $llenado = "S";
                $item['manten_coment'] = trim($item['manten_coment']);
                $item['manten_recllen'] = $llenado;
                $fechaCreacion = new DateTime(date("Y-m-d", strtotime($item['manten_feccre'] . " " . $item['manten_horcre'])));
                $intervalo = $fechaCreacion->diff($fechaActual);
                $item['condicion'] = ($intervalo->days);
                $item['manten_feccre'] = date("Y-m-d H:i", strtotime($item['manten_feccre'] . " " . $item['manten_horcre']));

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("mantenimientos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }


    public function Listar($data)
    {
        try {
            if (!isset($data['idusuario'])) return Funciones::RespuestaJson(2, "Debe establecer el idusuario");

            $usuario = trim($data['idusuario']);

            $sql = "SELECT *
                FROM tb_manten 
                WHERE manten_usucar = '$usuario'
                AND manten_estado <> 'FINALIZADO'
            ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();

            $fechaActual = new DateTime(date("Y-m-d"));

            foreach ($exec as $item) {

                $llenado = "N";

                if ($item['manten_recome'] != "") $llenado = "S";
                $item['manten_coment'] = trim($item['manten_coment']);
                $item['manten_recllen'] = $llenado;
                $fechaCreacion = new DateTime(date("Y-m-d", strtotime($item['manten_feccre'] . " " . $item['manten_horcre'])));
                $intervalo = $fechaCreacion->diff($fechaActual);
                $item['condicion'] = ($intervalo->days);
                $item['manten_feccre'] = date("Y-m-d H:i", strtotime($item['manten_feccre'] . " " . $item['manten_horcre']));

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("mantenimientos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Guardar($data)
    {
        try {
            if (!isset($data['areapro'])) return Funciones::RespuestaJson(2, "Debe establecer el aréa del problema");
            if (!isset($data['caracpro'])) return Funciones::RespuestaJson(2, "Debe establecer la caracteristica del problema");
            if (!isset($data['ubica'])) return Funciones::RespuestaJson(2, "Debe establecer la ubicación");
            if (!isset($data['comentario'])) return Funciones::RespuestaJson(2, "Debe establecer un comentario");

            $area = intval($data['areapro']);
            $caract = intval($data['caracpro']);
            $ubicac = trim($data['ubica']);
            $comentario = ucfirst(trim($data['comentario']));

            $areanom = "";
            $areaCaract = "";

            $sql = "INSERT INTO TB_MANTEN (MANTEN_PROBLE, MANTEN_UBICAC, MANTEN_CARACT, MANTEN_COMENT, MANTEN_FECCRE, MANTEN_HORCRE, )";

            return Funciones::RespuestaJson(1, "", $data);
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function ListarMantenHotel($data)
    {
        try {
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");

            $sucursal = strtoupper($data['sucursal']);

            $sql = "SELECT 
                manten_coment,manten_sucurs, manten_manten, manten_recome, manten_compan, MANTEN_CODINT,  
			    manten_usuari, manten_feccre, manten_horcre, 
				manten_usurev, MANTEN_FECREV, manten_horrev,  
				manten_usures, MANTEN_FECRES, manten_horres,
                manten_person, manten_codint
                FROM TB_MANTEN
                WHERE MANTEN_SUCURS = '$sucursal' 
                AND MANTEN_ESTADO IN ('EN PROCESO', 'ENVIADO')
                ORDER BY manten_codint DESC
            ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items  = array();

            $fechaActual = new DateTime(date("Y-m-d"));

            foreach ($exec as $item) {

                $codigo = 0;
                $nombre = "";
                $fecini = "";

                $ordman = intval($item['manten_manten']);

                if ($ordman > 0) {
                    $sqlAut = "SELECT 
                        (   SELECT EMPL_NOM_EMPL||' '||EMPL_APE_EMPL 
                            FROM SAEEMPL
                            WHERE EMPL_COD_EMPL = tecman_firsup
                            AND EMPL_COD_EEMP = 'A'
                        ) tecman_nomsup,
                        tecman_fecini||' '||tecman_horini as tecman_fecini,
                        tecman_codigo
                    FROM tb_tecman 
                    WHERE TECMAN_ORDMAN = $ordman
                ";
                    $execAuth = $this->Consulta($sqlAut);

                    if ($execAuth) {
                        $codigo = intval($execAuth['tecman_codigo']);
                        $nombre = $execAuth['tecman_nomsup'];
                        $fecini = is_null($execAuth['tecman_fecini']) ? '' : date("Y-m-d H:i", strtotime($execAuth['tecman_fecini']));
                    }
                }

                $item['tecman_codigo'] = $codigo;
                $item['tecman_nomsup'] = $nombre;
                $item['tecman_fecini'] = $fecini;

                $item['manten_codint'] = intval($item['manten_codint']);

                $item['manten_person'] = empty($item['manten_person']) ? '' : trim(str_replace(";", ", ", $item['manten_person']));

                $fechaCreacion = new DateTime(date("Y-m-d", strtotime($item['manten_feccre'] . " " . $item['manten_horcre'])));

                $intervalo = $fechaCreacion->diff($fechaActual);

                $item['condicion'] = ($intervalo->days);


                $item['manten_feccre'] = date("Y-m-d H:i", strtotime($item['manten_feccre'] . " " . $item['manten_horcre']));


                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("mantenimientos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Iniciar($data) //NO USADO
    {
        try {

            $manten = intval($data['manten']);
            $superv = trim($data['supervisor']);
            $tecnic = trim($data['tecnico']);

            $sql = "SELECT * FROM TB_MANTEN WHERE MANTEN_MANTEN = $manten";

            $mantenimiento = $this->Consulta($sql);

            if (!$mantenimiento) return Funciones::RespuestaJson(2, "No esites orden de mantennimiento");

            $empres = trim($mantenimiento['manten_compan']);
            $sucurs = trim($mantenimiento['manten_sucurs']);

            // COMPAN ID
            $sqlCompan = "SELECT compan_compan FROM tb_compan WHERE compan_nombre = '$empres'";

            $codCompan = 0;

            $execCompan = $this->Consulta($sqlCompan);

            if (!$execCompan) return Funciones::RespuestaJson(2, "No hay compania");

            $codCompan = intval($execCompan['compan_compan']);

            // SUCURS ID
            $sqlSucurs = "SELECT sucurs_sucurs FROM tb_sucurs WHERE sucurs_nombre = '$sucurs' AND SUCURS_COMPAN = $codCompan";

            $codSucurs = 0;

            $execSucurs = $this->Consulta($sqlSucurs);

            if (!$execSucurs) return Funciones::RespuestaJson(2, "No hay sucursal");

            $codSucurs = intval($execSucurs['sucurs_sucurs']);

            $date = date("m-d-Y");

            $time = date("H:i:s");

            $sqlExis = "SELECT * FROM tb_tEcman WHERE tecman_fecini IS NULL AND tecman_horini IS  NULL AND tecman_ordman = $manten";

            $execExiste = $this->Consulta($sqlExis, true);

            if (count($execExiste) > 0) return Funciones::RespuestaJson(2, ("YA ESTA INICIA ESA ORDEN DE TRABAJO"));

            $sqlGuardar = "INSERT INTO tb_tEcman (tecman_EMPRES, tecman_sucurs, tecman_ordman, tecman_firsup, tecman_firman, tecman_fecini, tecman_horini) 
                                            VALUES ($codCompan, $codSucurs, $manten, '$superv', '$tecnic', '$date','$time')";

            $guardar = $this->Consulta($sqlGuardar, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            return Funciones::RespuestaJson(1, "ORDEN DE TRABAJO INICIADO CON ÉXITO");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Finalizar($data)
    {
        try {
            $manten = intval($data['manten']);
            $superv = trim($data['supervisor']);
            $tecnic = trim($data['tecnico']);
            $tecman = intval($data['tecman']);
            $tipo = trim($data['tipo']);

            $sql = "SELECT * FROM TB_MANTEN WHERE MANTEN_MANTEN = $manten AND MANTEN_RECOME IS NOT NULL";

            $execSql = $this->Consulta($sql);

            if (!$execSql) return Funciones::RespuestaJson(2, "TÉCNICO DEBE LLENAR LA RECOMENDACIÓN");

            $addSentecia = "TECMAN_FECCIE IS NULL";

            if ($tipo == "") {
                $addSentecia = "tecman_fecprx IS NOT NULL";
            }

            $sqlExis = "SELECT * FROM tb_tEcman WHERE tecman_ordman = $manten AND $addSentecia";

            $execExiste = $this->Consulta($sqlExis);

            if (!$execExiste) return Funciones::RespuestaJson(2, "ORDEN DE TRABAJO NO INICIALIZADA");

            $tecman_codigo = intval($execExiste['tecman_codigo']);

            $date = date("m-d-Y");

            $time = date("H:i:s");

            $sqlFinal = "UPDATE tb_tEcman SET
                    tecman_ficsup = '$superv',
                    tecman_ficman = '$tecnic',
                    tecman_feccie = '$date',
                    tecman_horcie = '$time',
                WHERE tecman_ordman = '$manten'
                AND tecman_codigo = $tecman_codigo
            ";

            $execFinalizar = $this->Consulta($sqlFinal, false, true);

            if (!$execFinalizar) return Funciones::RespuestaJson(2, strtolower("ADVERTENCIA al actualizar registro"));

            // CERRAR MANTENNIMIENTO
            $time = date("H:i:s");

            $sqlCerrarMante = "UPDATE TB_MANTEN SET MANTEN_ESTADO = 'FINALIZADO', MANTEN_FECRES = TODAY, MANTEN_HORRES = '$time' WHERE MANTEN_MANTEN = $manten";

            $execCerrarManten  = $this->Consulta($sqlCerrarMante, false, true);

            if (!$execCerrarManten) return Funciones::RespuestaJson(2, "ADVERTENCIA, AL CERRAR ORDEN DE TRABAJO");

            return Funciones::RespuestaJson(1, "ORDEN FINALIZADA CON ÉXITO");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Continuar($data)
    {
        try {
            $manten = intval($data['manten']);
            $superv = trim($data['supervisor']);
            $tecnic = trim($data['tecnico']);
            $tecman = intval($data['tecman']);

            $sql = "SELECT * FROM TB_MANTEN WHERE MANTEN_MANTEN = $manten";

            $mantenimiento = $this->Consulta($sql);

            if (!$mantenimiento) return Funciones::RespuestaJson(2, "No esites orden de mantennimiento");

            $empres = trim($mantenimiento['manten_compan']);
            $sucurs = trim($mantenimiento['manten_sucurs']);

            // COMPAN ID
            $sqlCompan = "SELECT compan_compan FROM tb_compan WHERE compan_nombre = '$empres'";

            $codCompan = 0;

            $execCompan = $this->Consulta($sqlCompan);

            if (!$execCompan) return Funciones::RespuestaJson(2, "No hay compania");

            $codCompan = intval($execCompan['compan_compan']);

            // SUCURS ID
            $sqlSucurs = "SELECT sucurs_sucurs FROM tb_sucurs WHERE sucurs_nombre = '$sucurs' AND SUCURS_COMPAN = $codCompan";

            $codSucurs = 0;

            $execSucurs = $this->Consulta($sqlSucurs);

            if (!$execSucurs) return Funciones::RespuestaJson(2, "No hay sucursal");

            $codSucurs = intval($execSucurs['sucurs_sucurs']);

            $date = date("d-m-Y");

            $time = date("H:i:s");

            $sqlGuardar = "INSERT INTO tb_tEcman (tecman_EMPRES, tecman_sucurs, tecman_ordman, tecman_firsup, tecman_firman, tecman_fecprx, tecman_horprx) 
                                            VALUES ($codCompan, $codSucurs, $manten, '$superv', '$tecnic', '$date','$time')";

            $guardar = $this->Consulta($sqlGuardar, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            return Funciones::RespuestaJson(1, "REGISTRADO CON ÉXITO");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function Pausar($data)
    {
        try {
            $manten = intval($data['manten']);
            $superv = trim($data['supervisor']);
            $tecnic = trim($data['tecnico']);
            $tecman = intval($data['tecman']);

            $date = date("d-m-Y");

            $time = date("H:i:s");

            $sqlPausar = "UPDATE tb_tEcman SET
                    tecman_ficsup = '$superv',
                    tecman_ficman = '$tecnic',
                    tecman_fecreg = '$date',
                    tecman_horreg = '$time'
                WHERE tecman_ordman = '$manten'
                AND tecman_codigo = $tecman
            ";

            $exec = $this->Consulta($sqlPausar, false, true);

            if (!$exec) return Funciones::RespuestaJson(2, "ERROR AL ACTUALIZAR REGISTRO");

            return Funciones::RespuestaJson(1, "ACTUALIZADO CON ÉXITO");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function GuardarObservacion($data)
    {
        try {
            if (!isset($data['manten_manten'])) return Funciones::RespuestaJson(2, "DEBE ESTABLECER LA ORDEN DE MANTENNIMIENTO");
            if (!isset($data['observacion'])) return Funciones::RespuestaJson(2, "DEBE ESTABLECER LA OBSERVACIÓN");

            $manten_manten = intval($data['manten_manten']);
            $manten_observ = trim($data['observacion']);

            $sqlRecomendacion = "UPDATE TB_MANTEN SET MANTEN_RECOME = '$manten_observ' WHERE MANTEN_MANTEN = $manten_manten";

            $guardar = $this->Consulta($sqlRecomendacion, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            return Funciones::RespuestaJson(1, "OBSERVACIÓN GUARDADA");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

// NUEVAS DE APP FLUTTER

    public function ListarMantenHotelApp($data)
    {
        try {
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");

            $sucursal = strtoupper($data['sucursal']); //TEXTO 

            $sql = "SELECT 
                manten_coment,manten_sucurs, manten_manten, manten_recome, manten_compan, MANTEN_CODINT,  
			    manten_usuari, manten_feccre, manten_horcre, 
				manten_usurev, MANTEN_FECREV, manten_horrev,  
				manten_usures, MANTEN_FECRES, manten_horres,
                manten_person, manten_codint
                FROM TB_MANTEN
                WHERE MANTEN_SUCURS = '$sucursal' 
                AND MANTEN_ESTADO IN ('EN PROCESO', 'ENVIADO')
                ORDER BY manten_codint DESC
            ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items  = array();

            $fechaActual = new DateTime(date("Y-m-d"));

            foreach ($exec as $item) {

                $codigo = 0;
                $nombre = "";
                $fecini = "";

                $ordman = intval($item['manten_manten']);

                if ($ordman > 0) {
                    $sqlAut = "SELECT 
                        (   SELECT EMPL_NOM_EMPL||' '||EMPL_APE_EMPL 
                            FROM SAEEMPL
                            WHERE EMPL_COD_EMPL = tecman_firsup
                            AND EMPL_COD_EEMP = 'A'
                        ) tecman_nomsup,
                        tecman_fecini||' '||tecman_horini as tecman_fecini,
                        tecman_codigo
                    FROM tb_tecman 
                    WHERE TECMAN_ORDMAN = $ordman ";
                    $execAuth = $this->Consulta($sqlAut);

                    if ($execAuth) {
                        $codigo = intval($execAuth['tecman_codigo']);
                        $nombre = $execAuth['tecman_nomsup'];
                        $fecini = is_null($execAuth['tecman_fecini']) ? '' : date("Y-m-d H:i", strtotime($execAuth['tecman_fecini']));
                    }
                }

                $item['tecman_codigo'] = $codigo;
                $item['tecman_nomsup'] = $nombre;
                $item['tecman_fecini'] = $fecini;

                $item['manten_codint'] = intval($item['manten_codint']);

                $item['manten_person'] = empty($item['manten_person']) ? '' : trim(str_replace(";", ", ", $item['manten_person']));

                $fechaCreacion = new DateTime(date("Y-m-d", strtotime($item['manten_feccre'] . " " . $item['manten_horcre'])));

                $intervalo = $fechaCreacion->diff($fechaActual);

                $item['condicion'] = ($intervalo->days);

                $item['manten_feccre'] = date("Y-m-d H:i", strtotime($item['manten_feccre'] . " " . $item['manten_horcre']));

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("mantenimientos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }


    public function GuardarObservacionApp($data)
    {
        try {
            if (!isset($data['manten_manten'])) return Funciones::RespuestaJson(2, "DEBE ESTABLECER LA ORDEN DE MANTENNIMIENTO");
            if (!isset($data['observacion'])) return Funciones::RespuestaJson(2, "DEBE ESTABLECER LA OBSERVACIÓN");

            $manten_manten = intval($data['manten_manten']);
            $manten_observ = trim($data['observacion']);

            $sqlRecomendacion = "UPDATE TB_MANTEN SET MANTEN_RECOME = '$manten_observ' WHERE MANTEN_MANTEN = $manten_manten";

            $guardar = $this->Consulta($sqlRecomendacion, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            return Funciones::RespuestaJson(1, "OBSERVACIÓN GUARDADA");
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }


    public function ListadoMantenHotel($data)  //LISTADO DE MANTENIMIENTOS APK 
    {
        try {
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "Debe establecer la sucursal");

            $sucursal = strtoupper($data['sucursal']); //TEXTO 

            $sql = "SELECT 
                 b.compan_compan,manten_coment,manten_sucurs, manten_manten, manten_recome, manten_compan, MANTEN_CODINT,  
			    manten_usuari, manten_feccre, manten_horcre, 
				manten_usurev, MANTEN_FECREV, manten_horrev,  
				manten_usures, MANTEN_FECRES, manten_horres,
                manten_person, manten_codint
                FROM TB_MANTEN a 
				LEFT JOIN tb_compan b ON b.compan_nombre = a.manten_compan
                WHERE MANTEN_SUCURS = '$sucursal' 
                AND MANTEN_ESTADO IN ('EN PROCESO', 'ENVIADO')
                ORDER BY manten_codint DESC
            ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items  = array();

            $fechaActual = new DateTime(date("Y-m-d"));

            foreach ($exec as $item) {

                $codigo = 0;
				$estado = 0;
                $nombre = "";
                $fecini = "";

                $ordman = intval($item['manten_manten']);

				
				$item['estado'] = $this->Buscar_estado($ordman);
				$salida = $this->Buscar_datos($ordman);
                $item['tecman_codigo'] = $salida['tecman_codigo'];
                $item['tecman_nomsup'] = $salida['tecman_nomsup'];
                $item['tecman_fecini'] = $salida['tecman_fecini'];

                $item['manten_codint'] = intval($item['manten_codint']);

                $item['manten_person'] = empty($item['manten_person']) ? '' : trim(str_replace(";", ", ", $item['manten_person']));

                $fechaCreacion = new DateTime(date("Y-m-d", strtotime($item['manten_feccre'] . " " . $item['manten_horcre'])));

                $intervalo = $fechaCreacion->diff($fechaActual);

                $item['condicion'] = ($intervalo->days);

                $item['manten_feccre'] = date("Y-m-d H:i", strtotime($item['manten_feccre'] . " " . $item['manten_horcre']));

                $items[] = $item;
            }

            return Funciones::RespuestaJson(1, "", array("mantenimientos" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

	public function Buscar_estado($data)  // estado: 0= no iniciado / 1 = iniciado / 2 = pausado / 3= continuado / 4= finalizado
    {            
			$estado = 0;
			/* BUSCO ESTADO INICIADO*/
			
						
            $sql = "SELECT  Limit 1 *	FROM tb_tEcman 
						WHERE tecman_ordman=$data   ORDER BY tecman_codigo DESC";

            $exec = $this->Consulta($sql, true);

			$items = array();
			foreach ($exec as $item) {
				
				switch ($item) {
					
					//ESTADO INICIADO
					  case is_null($item['tecman_fecini'])!= true  && is_null($item['tecman_fecreg'])== true && is_null($item['tecman_fecprx'])== true && is_null($item['tecman_feccie'])== true :
					  
						$estado = 1;
						break;
					//ESTADO PAUSADO
					  case is_null($item['tecman_fecini'])!= true  && is_null($item['tecman_fecreg'])!= true && is_null($item['tecman_fecprx'])== true && is_null($item['tecman_feccie'])== true :
						$estado = 2;
						break;
					//ESTADO CONTINUADO
					   case is_null($item['tecman_fecini'])== true  && is_null($item['tecman_fecreg'])== true && is_null($item['tecman_fecprx'])!= true && is_null($item['tecman_feccie'])== true :
						$estado = 3;
						break;
					//ESTADO FINALIZADO
						 case is_null($item['tecman_feccie'])== true :
						$estado = 4;
						break;
						
					  default:
						break;
					}
			}

            return $estado;

    }



    public function GuardarIni($data, $files)
    {
        try {
			
            if (intval($data['manten']) == 0) return Funciones::RespuestaJson(2, "Debe establecer el mantenimiento");
            if (!isset($data['tipo_doc'])) return Funciones::RespuestaJson(2, "Debe establecer el tipo de documento");
			if (!isset($data['observacion'])) return Funciones::RespuestaJson(2, "Debe establecer el observacion");

            $superv = '8888888888'; //$data['supervisor'];
            $tecnic = trim($data['tecnico']);
			$observacion = trim($data['observacion']);
            $compania = intval($data['compania']);
			$sucursal = intval($data['sucursal']);
			$tecnico = intval($data['tecnico']);
			$totFil = intval($data['total']);
            $compan = $data['compan'];
            $tipdoc = strtolower($data['tipo_doc']);
            $manten = intval($data['manten']);
            $date = date("Y/m/d");
			$date2 = date("n/d/Y");
			$date3 = date("m-d-Y");

			$time = date("H:i:s");
            $os = php_uname();
            $root = "";
			$root = "C:/Archivos/$compan/$date/ordentrabajo/$manten";
			if (!file_exists($root)){
				mkdir($root, 0777, true);
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
			
			$sql = "UPDATE TB_MANTEN SET MANTEN_RECOME = '$observacion'  WHERE MANTEN_MANTEN = $manten";

						$actua = $this->Consulta($sql, false, true);
						if ($actua){ 
							
						}else{
							return Funciones::RespuestaJson(2, "Error al actualizar mantenimiento");
						}

            $sqlGuardar = "INSERT INTO tb_tEcman (tecman_EMPRES, tecman_sucurs, tecman_ordman, tecman_firsup, tecman_firman, tecman_fecini, tecman_horini) 
                                            VALUES ($compania, $sucursal, $manten, '$superv', '$tecnic', '$date3','$time')";

            $guardar = $this->Consulta($sqlGuardar, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            return Funciones::RespuestaJson(1, "ORDEN DE TRABAJO INICIADO CON ÉXITO");
			
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	

    public function GuardarPau($data, $files)
    {
        try {
            if (intval($data['manten']) == 0) return Funciones::RespuestaJson(2, "Debe establecer el mantenimiento");
            if (!isset($data['tipo_doc'])) return Funciones::RespuestaJson(2, "Debe establecer el tipo de documento");
			if (!isset($data['observacion'])) return Funciones::RespuestaJson(2, "Debe establecer el observacion");

            $superv = '8888888888'; //trim($data['supervisor']);
            $tecnic = '8888888888'; //trim($data['tecnico']);
			$observacion = trim($data['observacion']);
            $compania = intval($data['compania']);
			$sucursal = intval($data['sucursal']);
			$tecnico = '8888888888'; //intval($data['tecnico']);
			$totFil = intval($data['total']);
            $compan = $data['compan'];
            $tipdoc = strtolower($data['tipo_doc']);
            $manten = intval($data['manten']);
            $date = date("Y/m/d");
			$date2 = date("n/d/Y");
			$date3 = date("m-d-Y");
			$date4 = date("d-m-Y");
			$time = date("H:i:s");
            $os = php_uname();
            $root = "";
			$root = "C:/Archivos/$compan/$date/ordentrabajo/$manten";
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
			$sql = "UPDATE TB_MANTEN SET MANTEN_RECOME =  '$observacion'  WHERE MANTEN_MANTEN = $manten";

						$actua = $this->Consulta($sql, false, true);
						if ($actua){ 
							
						}else{
							return Funciones::RespuestaJson(2, "Error al actualizar mantenimiento");
						}
            $sqlPausar = "UPDATE tb_tEcman SET tecman_ficsup = '$superv', tecman_ficman = '$tecnic', tecman_fecreg = '$date3', tecman_horreg = '$time' 
						  WHERE tecman_ordman = '$manten'";

            $guardar = $this->Consulta($sqlPausar, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            return Funciones::RespuestaJson(1, "ORDEN DE TRABAJO PAUSADA CON ÉXITO");
			
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	

    public function GuardarCon($data, $files)
    {
        try {
            if (intval($data['manten']) == 0) return Funciones::RespuestaJson(2, "Debe establecer el mantenimiento");
            if (!isset($data['tipo_doc'])) return Funciones::RespuestaJson(2, "Debe establecer el tipo de documento");
			if (!isset($data['observacion'])) return Funciones::RespuestaJson(2, "Debe establecer el observacion");

            $superv = '8888888888'; //trim($data['supervisor']);
            $tecnic = '8888888888'; //trim($data['tecnico']);
			$observacion = trim($data['observacion']);
            $compania = intval($data['compania']);
			$sucursal = intval($data['sucursal']);
			$tecnico = '8888888888'; //intval($data['tecnico']);
			$totFil = intval($data['total']);
            $compan = $data['compan'];
            $tipdoc = strtolower($data['tipo_doc']);
            $manten = intval($data['manten']);
            $date = date("Y/m/d");
			$date2 = date("n/d/Y");
			$date3 = date("m-d-Y");
			$date4 = date("d-m-Y");
			$time = date("H:i:s");
            $os = php_uname();
            $root = "";
			$root = "C:/Archivos/$compan/$date/ordentrabajo/$manten";
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

			$sql = "UPDATE TB_MANTEN SET MANTEN_RECOME =  '$observacion'  WHERE MANTEN_MANTEN = $manten";

				$actua = $this->Consulta($sql, false, true);
				if ($actua){ 
					
				}else{
					return Funciones::RespuestaJson(2, "Error al actualizar mantenimiento");
				}
            $sqlGuardar = "INSERT INTO tb_tEcman (tecman_EMPRES, tecman_sucurs, tecman_ordman, tecman_firsup, tecman_firman, tecman_fecprx, tecman_horprx) 
                                            VALUES ($compania, $sucursal, $manten, '$superv', '$tecnic', '$date3','$time')";

            $guardar = $this->Consulta($sqlGuardar, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            return Funciones::RespuestaJson(1, "ORDEN DE TRABAJO CONTINUADA CON ÉXITO");
			
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	

    public function GuardarEnd($data, $files)
    {
        try {
            if (intval($data['manten']) == 0) return Funciones::RespuestaJson(2, "Debe establecer el mantenimiento");
            if (!isset($data['tipo_doc'])) return Funciones::RespuestaJson(2, "Debe establecer el tipo de documento");
			if (!isset($data['observacion'])) return Funciones::RespuestaJson(2, "Debe establecer el observacion");

            $superv = '8888888888'; //trim($data['supervisor']);
            $tecnic = '8888888888'; //trim($data['tecnico']);
			$observacion = trim($data['observacion']);
            $compania = intval($data['compania']);
			$sucursal = intval($data['sucursal']);
			$tecnico = '8888888888'; //intval($data['tecnico']);
			$totFil = intval($data['total']);
            $compan = $data['compan'];
            $tipdoc = strtolower($data['tipo_doc']);
            $manten = intval($data['manten']);
            $date = date("Y/m/d");
			$date2 = date("n/d/Y");
			$date3 = date("m-d-Y");
			$date4 = date("d-m-Y");
			$time = date("H:i:s");
            $os = php_uname();
            $root = "";
			$root = "C:/Archivos/$compan/$date/ordentrabajo/$manten";
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

			$sql = "UPDATE TB_MANTEN SET MANTEN_RECOME =  '$observacion'  WHERE MANTEN_MANTEN = $manten";

					$actua = $this->Consulta($sql, false, true);
					if ($actua){ 
						
					}else{
						return Funciones::RespuestaJson(2, "Error al actualizar mantenimiento");
					}
            $sqlFinal = "UPDATE tb_tEcman SET tecman_ficsup = '$superv', tecman_ficman = '$tecnic', tecman_feccie = '$date3',tecman_horcie = '$time' WHERE tecman_ordman = '$manten'";

            $guardar = $this->Consulta($sqlFinal, false, true);

            if (!$guardar) return Funciones::RespuestaJson(2, "ERROR AL GUARDAR");

            $sqlCerrarMante = "UPDATE TB_MANTEN SET MANTEN_ESTADO = 'FINALIZADO', MANTEN_FECRES = TODAY, 
							   MANTEN_HORRES = '$time' WHERE MANTEN_MANTEN = $manten";

            $execCerrarManten  = $this->Consulta($sqlCerrarMante, false, true);

            if (!$execCerrarManten) return Funciones::RespuestaJson(2, "ADVERTENCIA, AL CERRAR ORDEN DE TRABAJO");

            return Funciones::RespuestaJson(1, "ORDEN FINALIZADA CON ÉXITO");
			
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	
private function Buscar_datos($ordman)
{
    $sql = "SELECT tecman_firsup,tecman_fecini||' '||tecman_horini as tecman_fecini, tecman_codigo
                    FROM tb_tecman 
                    WHERE TECMAN_ORDMAN =  $ordman ORDER BY TECMAN_CODIGO DESC LIMIT 1";

    $execAuth = $this->Consulta($sql, true);

	if($execAuth){
		
		 foreach ($execAuth as $item) {

			$supervisor = $item['tecman_firsup'];
		
	 		$sqlSuper = "SELECT EMPL_NOM_EMPL||' '||EMPL_APE_EMPL as tecman_nomsup FROM SAEEMPL 
			 WHERE EMPL_COD_EMPL = '$supervisor' LIMIT 1  ";

			$execSuper = $this->Consulta($sqlSuper, true);
			
				if($execSuper){
					foreach ($execSuper as $item2) {
					$salida['tecman_nomsup'] = $item2['tecman_nomsup'];
					}
				}
				else{
					$salida['tecman_nomsup'] = 'N/P';
				}
			
		$salida['tecman_fecini'] = $item['tecman_fecini'];
		$salida['tecman_codigo'] = $item['tecman_codigo']; 
		 }
	
	}
	else 
	{

		$salida = ['tecman_nomsup'=>'N/P','tecman_fecini'=>'N/P','tecman_codigo'=>'N/P'];
	}
  
    return $salida;
}
}
