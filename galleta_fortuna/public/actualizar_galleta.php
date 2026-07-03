<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/services/FortuneService.php";

$id = intval($_POST["id"] ?? 0);
$texto = trim($_POST["texto"] ?? "");

$fortuneService = new FortuneService();

$resultado = $fortuneService->actualizarGalleta($id, $texto);

if ($resultado) {
    $_SESSION["admin_success"] = "Galleta actualizada correctamente.";
} else {
    $_SESSION["admin_error"] = "No se pudo actualizar la galleta.";
}

header("Location: admin_panel.php");
exit;