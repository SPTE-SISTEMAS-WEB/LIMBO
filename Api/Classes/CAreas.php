<?php
class Areas extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();
    }

    public function Listar()
    {
        try {
            $sql = "";

            $areas = array(
                array(
                    "areasp_areasp" => 1,
                    "areasp_nombre" => "SOLICITUD PEDIDOS"
                ),
                array(
                    "areasp_areasp" => 2,
                    "areasp_nombre" => "{ OTROS }"
                ),
                array(
                    "areasp_areasp" => 3,
                    "areasp_nombre" => "AIRE ACONDICIONADO"
                ),
                array(
                    "areasp_areasp" => 4,
                    "areasp_nombre" => "ALUMINIO Y VIDRIO"
                ),
                array(
                    "areasp_areasp" => 5,
                    "areasp_nombre" => "CARPINTERIA"
                ),
                // array(
                //     "areasp_areasp" => 6,
                //     "areasp_nombre" => "ELECTRICO"
                // ),
                // array(
                //     "areasp_areasp" => 7,
                //     "areasp_nombre" => "ELECTRONICO"
                // ),
                // array(
                //     "areasp_areasp" => 8,
                //     "areasp_nombre" => "GASFITERIA"
                // ),
                // array(
                //     "areasp_areasp" => 9,
                //     "areasp_nombre" => "LETREROS"
                // ),
                // array(
                //     "areasp_areasp" => 10,
                //     "areasp_nombre" => "OBRA CIVIL"
                // ),
            );

            return Funciones::RespuestaJson(1, "", array("areas" => $areas));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
