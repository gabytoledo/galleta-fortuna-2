<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/repositories/UsuarioRepository.php";

$id = intval($_POST["id"] ?? 0);
$rol = $_POST["rol"] ?? "";

if ($id <= 0 || !in_array($rol, ["usuario", "admin"])) {
    $_SESSION["admin_error"] = "Datos inválidos para actualizar el rol.";
    header("Location: admin_usuarios.php");
    exit;
}

if ($id === (int)$_SESSION["usuario_id"]) {
    $_SESSION["admin_error"] = "No podés cambiar tu propio rol desde el panel.";
    header("Location: admin_usuarios.php");
    exit;
}

$usuarioRepository = new UsuarioRepository();
$resultado = $usuarioRepository->actualizarRolPorId($id, $rol);

$_SESSION[$resultado ? "admin_success" : "admin_error"] =
    $resultado ? "Rol actualizado correctamente." : "No se pudo actualizar el rol.";

header("Location: admin_usuarios.php");
exit;