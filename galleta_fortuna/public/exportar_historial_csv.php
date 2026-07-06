<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireLogin();

require_once __DIR__ . "/../app/repositories/HistorialRepository.php";

$historialRepository = new HistorialRepository();

$historial = $historialRepository->obtenerPorUsuario(
    (int) $_SESSION["usuario_id"]
);

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=historial_galletas.csv");

$output = fopen("php://output", "w");

fputcsv($output, ["Fecha", "Mensaje"], ";");

foreach ($historial as $item) {
    $fecha = new DateTime($item["fecha_apertura"]);

    fputcsv($output, [
        $fecha->format("d/m/Y H:i:s"),
        $item["mensaje"]
    ], ";");
}

fclose($output);
exit;