<?php
class Cliente extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();
		
		date_default_timezone_set("America/Guayaquil");
    }

    public function Buscar_Cliente($data)
    {		
        try {
			
			$ruc = strtoupper($data['ruc']);
			$empresa = $data['empresa'];
			
            $sql = "SELECT clpv_nom_clpv,clpv_cod_clpv,clpv_ruc_clpv  
					FROM saeclpv 
					WHERE clpv_est_clpv = 'A' 
					AND clpv_cod_empr =$empresa
					AND clpv_clopv_clpv='CL'
					AND clpv_nom_clpv like '%$ruc%' ";
					
            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No existe una empresa con ese ruc");

            return Funciones::RespuestaJson(1, "Busqueda exitosa!", array("company" => $exec));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
