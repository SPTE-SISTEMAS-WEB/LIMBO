<?php
class Funciones
{
    public static function RespuestaJson($estado = 3, $mensaje = "", $data = array())
    {
        $respuesta = new stdClass();
        $respuesta->estado = $estado;
        $respuesta->mensaje = $mensaje;
        $respuesta->data = $data;
        return $respuesta;
    }

    public static function Logs($nombreLog, $mensaje)
    {
        $fechaLog = date("Y/m/d");

        $ubi = "../Logs/";

        if (!file_exists("$ubi" . $fechaLog)) mkdir("$ubi" . $fechaLog, 0777, true);

        $path = "$ubi" . $fechaLog . "/$nombreLog.txt";

        $mensaje = date("Y/m/d H:i:s") . " >>>> " . $mensaje . "\n\r";

        $archivo = fopen($path, "a+");
        fwrite($archivo, $mensaje);
        fclose($archivo);
    }
}
