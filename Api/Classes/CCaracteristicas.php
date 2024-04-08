<?php
class Caracteristicas extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();
    }
    
    public function Listar($data)
    {
        try {

            $areasp_areasp = intval($data["areasp_areasp"]);

            $sql = "";

            $areas = array(
                array(
                    "areasp_areasp" => 1,
                    "carpro_nombre" => "PEDIDOS MANTENIMIENTO",
                    "carpro_carpro" => 11
                ),
                array(
                    "areasp_areasp" => 2,
                    "carpro_nombre" => "{ OTROS }",
                    "carpro_carpro" => 12
                ),
                array(
                    "areasp_areasp" => 3,
                    "carpro_nombre" => "NO ENCIENDE",
                    "carpro_carpro" => 13
                ),
                array(
                    "areasp_areasp" => 3,
                    "carpro_nombre" => "NO ENCIENDE CONGELADOR",
                    "carpro_carpro" => 14
                ),
                array(
                    "areasp_areasp" => 4,
                    "carpro_nombre" => "ARREGLAR VELADORES EN MAL ESTADO",
                    "carpro_carpro" => 15
                ),
                array(
                    "areasp_areasp" => 4,
                    "carpro_nombre" => "ARREGLO DE ANAQUELES",
                    "carpro_carpro" => 16
                ),
                array(
                    "areasp_areasp" => 5,
                    "carpro_nombre" => "CAMBIAR CHAPA ELECTRICA",
                    "carpro_carpro" => 15
                ),
                array(
                    "areasp_areasp" => 5,
                    "carpro_nombre" => "CAMBIAR TACO INTERRUPTOR",
                    "carpro_carpro" => 16
                ),
            );
            
            $items = array();

            foreach($areas as $item){

                if (intval($item['areasp_areasp']) == $areasp_areasp ){
                    $items[] = $item;
                }
            }

            return Funciones::RespuestaJson(1, "", array("caracteristicas" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}