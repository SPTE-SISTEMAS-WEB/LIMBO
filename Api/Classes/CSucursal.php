<?php
class Sucursal extends DBConexion
{
    public function __construct()
    {
        parent::__construct();
        parent::Conexion();
    }

    public function Listar()
    {
        try {
            $sql = "SELECT 
                (  
                    SELECT REPI_COD_SUCU 
                    FROM SAEREPI 
                    WHERE REPI_TIP_REPI = 5050 
                    AND REPI_EST_REPI = 1 
                    AND REPI_COD_SUCU = SUCURS_CODHOT 
                ) HHOT,
                ( 
                    SELECT sucu_num_fact 
                    FROM saesucu WHERE sucu_cod_sucu IN (  
                        SELECT REPI_COD_SUCU 
                        FROM SAEREPI 
                        WHERE REPI_TIP_REPI = 5050 
                        AND REPI_EST_REPI = 1 
                        AND REPI_COD_SUCU = SUCURS_CODHOT 
                    ) 
                ) punto,
                * 
                FROM TB_SUCURS
                ORDER BY SUCURS_NOMBRE
            ";

            $exec = $this->Consulta($sql, true);

            if (count($exec) == 0) return Funciones::RespuestaJson(2, "No hay datos para mostrar");

            $items = array();
			$item['sucurs_sucurs'] = "0";
            $item['sucurs_nombre'] = "SELECCIONE";
            foreach ($exec as $item) {
                $hotel['sucurs_sucurs'] =  intval($item['sucurs_sucurs']);
                $hotel['sucurs_nombre'] =  $item['sucurs_nombre'];
                $items[] = $hotel;
            }

            return Funciones::RespuestaJson(1, "", array("total" => count($items), "sucursales" => $items));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
