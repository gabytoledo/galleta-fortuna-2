<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireLogin();

require_once __DIR__ . "/../app/repositories/FavoritoRepository.php";

$mensaje = trim($_POST["mensaje"] ?? "");

if ($mensaje === "") {
    $_SESSION["favorito_error"] = "No hay mensaje para guardar.";
    header("Location: fortune.php");
    exit;
}

$favoritoRepository = new FavoritoRepository();

$resultado = $favoritoRepository->guardar(
    (int)$_SESSION["usuario_id"],
    $mensaje
);

if ($resultado) {
    $_SESSION["favorito_success"] = "Fortuna guardada como favorita.";
} else {
    $_SESSION["favorito_error"] = "No se pudo guardar la fortuna.";
}

header("Location: fortune.php");
exit;