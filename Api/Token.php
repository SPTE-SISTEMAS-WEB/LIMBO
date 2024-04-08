<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(-1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once "../vendor/autoload.php";

require_once "../Config.php";

class Token
{

    public static function CrearToken(array $data, $days = 1, $tipo = "day")
    {
        date_default_timezone_set("America/Guayaquil");

        $key = KEYPASS;

        $startTime = date("d-m-Y H:i:s");

        // $endTime = date("d-m-Y H:i:s", strtotime("$startTime"));

        if ($tipo == "day") {
            if ($days == 1) {
                $expToken = date("d-m-Y", strtotime("+24 hours $startTime"));
            } else {
                $totaldiasmens = date("t");
                $diaActual = date("j");
                $diasDiferencia = $totaldiasmens - $diaActual;
                $expToken = date("d-m-Y 23:59:59", strtotime("+$diasDiferencia days"));
            }
        } else {
            $expToken = date("d-m-Y H:i:s", strtotime("+2 minutes"));
        }

        $payload = [
            // 'uid'    => 1,
            // 'aud'    => 'http://site.com',
            'scopes' => $data,
            // 'iss'    => 'http://api.mysite.com',
            'iat'    => strtotime($startTime),
            // 'nbf'    => strtotime($endTime),
            'exp'    => strtotime($expToken)
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $token;
    }

    public static function VerificarToken($headers)
    {
        try {

            if (!isset($headers['token'])) return array("estado" => false, "mensaje" => "Debe especifcar el token en la cabecera");

            $key = KEYPASS;
            $token = ($headers['token']);

            date_default_timezone_set("America/Guayaquil");

            $decoded = (array) JWT::decode($token, new Key($key, 'HS256'));

            return array("estado" => true, "mensaje" => "", "data" => $decoded);
        } catch (Exception $e) {
            return array("estado" => false, "mensaje" => "Token expirado");
        }
    }
}
