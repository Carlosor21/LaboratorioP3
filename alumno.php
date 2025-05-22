<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Solo se permite método POST"]);
    exit;
}

$datos = json_decode(file_get_contents('php://input'), true);

if (!isset($datos['Nombre']) || !isset($datos['Laboratorio1']) || !isset($datos['Laboratorio2']) || !isset($datos['Parcial'])) {
    http_response_code(400);
    echo json_encode(["error" => "Faltan datos requeridos"]);
    exit;
}

$nombre = trim($datos['Nombre']);
$lab1 = floatval($datos['Laboratorio1']);
$lab2 = floatval($datos['Laboratorio2']);
$parcial = floatval($datos['Parcial']);

if ($lab1 < 0 || $lab1 > 10 || $lab2 < 0 || $lab2 > 10 || $parcial < 0 || $parcial > 10) {
    http_response_code(400);
    echo json_encode(["error" => "Las notas deben estar entre 0 y 10"]);
    exit;
}

$promedio = ($lab1 * 0.25) + ($lab2 * 0.25) + ($parcial * 0.5);
$promedio = round($promedio, 2);

$respuesta = [
    "nombre" => $nombre,
    "promedio" => $promedio
];

echo json_encode($respuesta);
