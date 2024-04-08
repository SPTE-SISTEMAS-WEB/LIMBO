<?php

class Seguridad extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();
        
        date_default_timezone_set("America/Guayaquil");
    }

    public function GenerarTokenUsuario($data){
        try {
            if (!isset($data['usuario'])) return Funciones::RespuestaJson(2, "DEBE ESPECIFICAR EL USUARIO");
            
            $fechaLoggin = date("Y-m-d H:i:s");
            $usuario = trim($data['usuario']);

            $sql = "SELECT * FROM SAEEMPL WHERE EMPL_COD_EMPL = '$usuario'";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "No existe colaborador con el número de cédula '$usuario'");

            // $token['idusuario'] = $exec['emp_cod_empl'];
            $token['nombre'] = $exec['empl_nom_empl'];
            $token['apellido'] = $exec['empl_ape_empl'];

            require "Token.php";
            $tokenString = Token::CrearToken($token, 30, "day");
            $token['fechaIngreso'] = $fechaLoggin;
            // $token['fechaRefresToken'] = date("Y-m-d H:i:s", strtotime("+$duracion minutes " .$fechaLoggin));

            return Funciones::RespuestaJson(1, "", array("usuario" => $token, "token" => $tokenString));

        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }

    public function GenerarToken($data)
    {
        try {
            if (!isset($data['sucursal'])) return Funciones::RespuestaJson(2, "DEBE ESPECIFICAR LA SUCURSAL");

            $sucursal = intval($data['sucursal']);

            // $sql = "SELECT * FROM tb_sucurs WHERE sucurs_sucurs = $sucursal";
            $sql = "SELECT * FROM SAESUCU WHERE SUCU_COD_SUCU = $sucursal";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "ERROR SUCURSAL NO DISPONIBLE");

            // $idsucurs = intval($exec['sucurs_sucurs']);
            // $nombre = strtoupper($exec['sucurs_nombre']);

            $idsucurs = intval($exec['sucu_cod_sucu']);
            $nombre = strtoupper($exec['sucu_nom_sucu']);

            require_once "Token.php";

            $token['idsucursal'] = $sucursal;
            $token['nombre'] = $nombre;

            $tokenString = Token::CrearToken($token, 31);

            $output['fechaIng'] = date("Y-m-d H:i:s");
            $output['idsucursal'] = $sucursal;
            $output['sucursal'] = $nombre;
            $output['token'] = $tokenString;

            return Funciones::RespuestaJson(1, "", array("sucursal" => $output));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
