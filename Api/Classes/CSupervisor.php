<?php
class Supervisor extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();

        date_default_timezone_set("America/Guayaquil");
    }

    public function Consultar($data)
    {
        try {
            $documento = trim($data['documento']);

            $sql = "SELECT EMPL_COD_EMPL AS DOC_SUPER, EMPL_APE_NOMB AS NOM_SUPER
            FROM SAEEMPL 
            WHERE EMPL_COD_EMPL = '$documento' 
            AND EMPL_COD_EEMP = 'A'";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "SUPERVISOR NO VÁLIDO");

            return Funciones::RespuestaJson(1, "", array("supervisor" => $exec));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
	/******    PARA PASAR CUANDO ESTE LISTA EL API ******/
	
    public function Consultar2($data)
    {
        try {
            $documento = trim($data['documento']);

            $sql = "SELECT EMPL_COD_EMPR as idempresa, EMPL_COD_EMPL as identificacion,EMPL_APE_NOMB as nombre,EMPL_COD_CIUD as ciudad ,
							b.sucu_cod_sucu as idsucursal,b.sucu_cod_empr as empresa,b.sucu_nom_sucu as nombre_sucursal
			FROM SAEEMPL a LEFT JOIN saesucu b ON  a.EMPL_COD_EMPR = b.sucu_cod_sucu
			WHERE EMPL_COD_EMPL = 'A'";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "USUARIO NO VÁLIDO");

            return Funciones::RespuestaJson(1, "", array("empleado" => $exec));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
