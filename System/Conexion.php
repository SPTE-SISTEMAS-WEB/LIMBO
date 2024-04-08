<?php

class DBConexion
{
    private $dns;
    private $motor;
    private $usuario;
    public $conexion = null;
    private $contrasena;

    public function __construct()
    {
        $this->dns = DNS;
        $this->motor = MOTOR;
        $this->contrasena = PASS;
        $this->usuario = USUARIO;
    }

    public function Conexion()
    {
        try {
            $pdo = new PDO("{$this->motor}:DSN={$this->dns}", $this->usuario, $this->contrasena);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion = $pdo;
        } catch (PDOException $e) {
            Funciones::Logs("DBConexion", "Error de conexion => " . $e);
        }
    }

    // CU = CREATE O UPATE
    public function Consulta($sql, $alldata = false, $CU = false)
    {
        try {
            if ($CU) {
                $estado = $this->conexion->prepare($sql)->execute();

                return array("estado" => $estado);
            } else {
                $data = $this->conexion->query($sql);
                if ($alldata) {
                    return $data->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return $data->fetch(PDO::FETCH_ASSOC);
                }
            }
        } catch (PDOException $e) {
            Funciones::logs("DBConsulta", "( $sql ) => " . $e->getMessage());
            die("Error de petición. (" . $sql . ") => " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        if ($this->conexion) {
            $this->conexion = null;
        }
    }
}
