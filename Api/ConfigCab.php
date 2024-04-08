<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Headers: *");

header("Content-Type: application/json; charset=UTF-8");

require_once "../System/Funciones.php";

$data = isset($_GET['metodo']) ? $_GET : $_POST;

$headers = getallheaders();
