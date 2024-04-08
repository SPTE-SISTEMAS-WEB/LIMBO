<?php
class Tecnico extends DBConexion
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
            if (!isset($data['documento'])) return Funciones::RespuestaJson(2, "DEBE ESTABLECER EL NÚMERO DE DOCUMENTO");
            if (!isset($data['ordman'])) return Funciones::RespuestaJson(2, "DEBE ESTABLECER EL NÚMERO DE ORDEN DE MANTENIMIENTO");

            $documento = trim($data['documento']);
            $ordman = intval($data['ordman']);

            $sql = "SELECT EMPL_NOM_EMPL||' '||EMPL_APE_EMPL NOM_TEC, EMPL_COD_EMPL DOC_TEC
            FROM SAEEMPL 
            WHERE EMPL_COD_EMPL = '$documento'
            AND EMPL_COD_EEMP = 'A'";

            $exec = $this->Consulta($sql);

            if (!$exec) return Funciones::RespuestaJson(2, "TECNICO NO VÁLIDO");
   
            $ini = "N";
            $pau = "N";
            $con = "N";
            $fin = "N";

            // INICIAR UNA NUEVA ORDEN DE TRABAJO
            $sqliniciar = "SELECT * FROM TB_TECMAN WHERE TECMAN_FIRMAN = '$documento' AND TECMAN_ORDMAN = $ordman";
            $execIniciar = $this->Consulta($sqliniciar, true);
            if( count($execIniciar) == 0 )  $ini = "S";

            // PAUSA UNA ORDEN DE TRABAJO
            $sqlPausa = "SELECT * FROM TB_TECMAN WHERE TECMAN_FIRMAN = '$documento' AND TECMAN_ORDMAN = $ordman AND TECMAN_FECINI IS NOT NULL AND  TECMAN_FECREG IS NULL";
            $execPausa = $this->Consulta($sqlPausa, true);
            if ( count($execPausa) > 0 ) $pau = "S";

            // CONTINUAR UNA ORDEN DE TRABAJO
            $sqlContinuar = "SELECT * FROM TB_TECMAN WHERE TECMAN_FIRMAN = '$documento' AND TECMAN_ORDMAN = $ordman AND TECMAN_FECPRX IS NOT NULL AND TECMAN_FECCIE IS NULL";
            $exexContinuar = $this->Consulta($sqlContinuar, true);
            if($ini == "N"){
                if( count($exexContinuar) == 0 && $pau == "N") $con = "S";
            }
            // $con = $sqlContinuar;

            // // FINALIZAR ORDEN DE TRABAJO
            // $sqlFinalizar = "SELECT * FROM TB_TECMAN WHERE TECMAN_FIRMAN = '$documento' AND TECMAN_ORDMAN = $ordman AND TECMAN_FECPRX IS NOT NULL";
            // $execFinalizar = $this->Consulta($sqlFinalizar, true);
            // if ( count($execFinalizar) > 0) $fin = "S";
            // // $fin = $sqlFinalizar;

            if ( $ini == "N" ) $fin = "S";

            $exec['ini'] = $ini;
            $exec['pau'] = $pau;
            $exec['con'] = $con;
            $exec['fin'] = $fin;

            return Funciones::RespuestaJson(1, "", array("tecnico" => $exec));
        } catch (Exception $e) {
            Funciones::Logs(basename(__FILE__, '.php'), $e);
            return Funciones::RespuestaJson(2, "Error de servidor interno");
        }
    }
}
