<?php
class LogginLimbo extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();
    }

    public function Loggin($data)
    {
        try {
            if (!isset($data['usuario'])) return Funciones::RespuestaJson(2, "Debe establecer el usuario");

            $usuario = trim(strtoupper($data['usuario']));
			$empresa = trim(strtolower($data['empresa']));

            $sql ="SELECT usua_nom_usua,usua_cod_usua FROM saeusua  LEFT JOIN saeacce on saeacce.acce_cod_usua=saeusua.usua_cod_usua WHERE  ACCE_COD_EMPR = '$empresa' AND saeusua.usua_nom_usua='$usuario'  GROUP BY usua_nom_usua,usua_cod_usua";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "No existe colaborador con el usuario '$usuario'");

            $token['usua_nom_usua'] = strval($exec['usua_nom_usua']);
            $token['usua_cod_usua'] = strval($exec['usua_cod_usua']);

            return Funciones::RespuestaJson(1, "Ingreso exitoso!", array("usuario" => $token));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	

	


}
