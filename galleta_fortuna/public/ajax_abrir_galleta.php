<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::start();

header("Content-Type: application/json");

require_once __DIR__ . "/../app/services/FortuneService.php";

if (!isset($_SESSION["usuario_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Usuario no autenticado."
    ]);
    exit;
}

$latitud = $_POST["latitud"] ?? null;
$longitud = $_POST["longitud"] ?? null;

$fortuneService = new FortuneService();

$resultado = $fortuneService->abrirGalleta(
    (int) $_SESSION["usuario_id"],
    $latitud,
    $longitud
);

if ($resultado === null) {
    echo json_encode([
        "success" => false,
        "message" => "No hay mensajes disponibles."
    ]);
    exit;
}

$_SESSION["mensaje_fortuna"] = $resultado["mensaje"];
$_SESSION["fecha_fortuna"] = $resultado["fecha"];
$_SESSION["clima_fortuna"] = $resultado["clima"];

echo json_encode([
    "success" => true,
    "mensaje" => $resultado["mensaje"],
    "fecha" => $resultado["fecha"],
    "clima" => $resultado["clima"]
]);