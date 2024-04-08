<?php

class Colaborador extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }

    public function BuscarColaborador($data)
    {
        try {
            if (!isset($data['num_doc'])) return Funciones::RespuestaJson(2, "Debe establecer el número de documento");

            $num_doc = trim($data['num_doc']);

            $sql = "SELECT 
                EMPL_COD_EMPL,
                EMPL_APE_NOMB, 
                    (   SELECT MIN(ESEM_FEC_INGR) 
                        FROM SAEESEM
                        WHERE ESEM_COD_EMPL = EMPL_COD_EMPL
                    ) MIN_INGRESO, 
                    (   SELECT ESEM_COD_ESTR 
                        FROM SAEESEM 
                        WHERE ESEM_COD_EMPL = EMPL_COD_EMPL 
                        AND ESEM_COD_EMPR = EMPl_COD_EMPR 
                        AND esem_fec_sali IS NULL
                    ) COD,
                    (   SELECT ESTR_des_estr 
                        FROM saeestr 
                        WHERE estr_cod_estr = ( 
                            SELECT ESEM_COD_ESTR  
                            FROM SAEESEM 
                            WHERE ESEM_COD_EMPL = EMPL_COD_EMPL 
                            AND ESEM_COD_EMPr = EMPl_COD_EMPR 
                            AND esem_fec_sali IS NULL
                        ) 
                    ) cargo,
                (   SELECT EMPR_COD_EMPR 
                    FROM SAEEMPR 
                    WHERE EMPR_COD_EMPR = EMPL_COD_EMPR 
                ) COD_EMPRESA,
                (   SELECT EMPR_NOM_EMPR 
                    FROM SAEEMPR 
                    WHERE EMPR_COD_EMPR = ( 
                        SELECT ESEM_COD_EMPR 
                        FROM SAEESEM 
                        WHERE ESEM_COD_EMPL = EMPL_COD_EMPL 
                        AND ESEM_COD_EMPR = EMPl_COD_EMPR 
                        AND esem_fec_sali IS
                    ) 
                ) EMPRESA
                FROM SAEEMPL
                WHERE EMPL_COD_EMPL = '$num_doc' 
                AND EMPL_COD_EEMP = 'A'
            ";

            $execEmpleado = $this->Consulta($sql);

            if (!$execEmpleado) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            return Funciones::RespuestaJson(1, "", array("colaborador" => $execEmpleado));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function ConsultarCamarera($data)
    {
        try {
            if (!isset($data['documento'])) return Funciones::RespuestaJson(2, "DEBE ESTABLECER N° DE DOCUMENTO");

            $documento = trim($data['documento']);
            $sucursal = intval($data['sucursalToken']);

            $sql = "SELECT amed_cod_empl,
                (
                    SELECT empl_ape_nomb 
                    FROM SAEEMPL 
                    WHERE EMPL_COD_EMPL = AMED_COD_EMPL 
                    AND EMPL_COD_EEMP = 'A'
                ) empl_ape_nomb
                FROM saeamed 
                WHERE amed_cod_empl = '$documento' 
                AND amed_cod_estr LIKE '%CAMA%'
                -- AND amed_cod_sucu = $sucursal
		-- AND amed_fec_amed = today
            ";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "CAMARERA '$documento', NO SE ENCUENTRA DENTRO DE LA PLANIFICACIÓN DEL HOTEL");

            return Funciones::RespuestaJson(1, "", array('camarera' => $exec));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
