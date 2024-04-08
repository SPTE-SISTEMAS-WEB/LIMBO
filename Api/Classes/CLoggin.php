<?php
class Loggin extends DBConexion
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

            $fechaLoggin = date("Y-m-d H:i:s");
            $usuario = trim(strtolower($data['usuario']));

            $sql = "SELECT * FROM TB_EMPLEA WHERE EMPLEA_CEDULA = '$usuario'";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "No existe colaborador con el número de cédula '$usuario'");

            $duracion = (60 * 10);
            $token['idusuario'] = intval($exec['emplea_emplea']);
            $token['nombre'] = $exec['emplea_nombre'];
            $token['apellido'] = $exec['emplea_apelli'];

            require "Token.php";
            $tokenString = Token::CrearToken($token, 30, "day");
            $token['fechaIngreso'] = $fechaLoggin;

            return Funciones::RespuestaJson(1, "", array("usuario" => $token, "token" => $tokenString));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	

	
	/******    PARA PASAR CUANDO ESTE LISTA EL API APP PEDIDOS  ******/
	
	    public function Loggin2($data)
    {
        try {
            if (!isset($data['usuario'])) return Funciones::RespuestaJson(2, "Debe establecer el usuario");

            $fechaLoggin = date("Y-m-d H:i:s");
            $usuario = trim(strtolower($data['usuario']));

            $sql = "SELECT f.empl_cod_empl,a.vend_cod_vend as codvendedor,a.vend_cod_sucu as sucursal,a.vend_ruc_vend as ruc ,
						   a.vend_cod_empr,a.vend_nom_vend as nombreVendedor,b.usua_cod_usua  ,b.usua_nom_usua,c.sucu_nom_sucu ,c.sucu_cod_sucu idSucursal
					FROM saevend a 
					LEFT JOIN saeusua b ON  a.vend_ruc_vend  = b.usua_cod_empl 
					LEFT JOIN saeempl f ON  a.vend_ruc_vend  = f.empl_cod_empl 
					LEFT JOIN saesucu c ON  a.vend_cod_empr  = c.sucu_cod_sucu 
					WHERE vend_ruc_vend = '$usuario' AND vend_est_vend= 1";
					

            $exec = $this->Consulta($sql);

            //if (!$exec) return Funciones::RespuestaJson(2, "No existe el vendedor con la cédula '$usuario'");
			if (!$exec['empl_cod_empl']) return Funciones::RespuestaJson(2, "No existe empleado con la cédula '$usuario'");
			if (!$exec['codvendedor']) return Funciones::RespuestaJson(2, "No existe vendedor con la cédula '$usuario'");
			if (!$exec['usua_cod_usua']) return Funciones::RespuestaJson(2, "No existe usuario con la cédula '$usuario'");
			
			/***vendedor no tiene id***/
            $token['codvendedor'] = strval($exec['codvendedor']);
			$token['ruc'] = strval($exec['ruc']);
			$token['sucursal'] = strval($exec['sucursal']);
			
			/***usuario***/
			$token['idusuario'] = $exec['usua_cod_usua'];
			$token['nomUsuario'] = strval($exec['usua_nom_usua']);
            $token['idempresa'] = intval($exec['vend_cod_empr']);
			$token['nombreEmpresa'] = strval($exec['sucu_nom_sucu']);


            require "Token.php";
            $tokenString = Token::CrearToken($token, 30, "day");
            $token['fechaIngreso'] = $fechaLoggin;

            return Funciones::RespuestaJson(1, "", array("usuario" => $token, "token" => $tokenString));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
	
		/******    LOGIN PHONE ******/
	
	    public function LogginPhone($data)
    {
        try {
            if (!isset($data['phone'])) return Funciones::RespuestaJson(2, "Debe establecer el telefono");

            $usuario = trim(strtolower($data['phone']));

            $sql = "SELECT telemp_celnum as numero from tb_telemp WHERE telemp_celest = 1 and telemp_celnum = '$usuario'";
            $exec = $this->Consulta($sql);

			if (!$exec) return Funciones::RespuestaJson(2, "El numero'$usuario' no esta autorizado!");

			 $token['numero'] = strval($exec['numero']);

            return Funciones::RespuestaJson(1, "", array("numero" => $token));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
