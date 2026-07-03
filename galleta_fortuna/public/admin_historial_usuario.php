<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/services/FortuneService.php";
require_once __DIR__ . "/../app/services/UserService.php";

$usuarioId = intval($_GET["id"] ?? 0);

$fortuneService = new FortuneService();
$userService = new UserService();

$usuarios = $userService->obtenerTodosLosUsuarios();
$usuarioSeleccionado = null;

foreach ($usuarios as $usuario) {
    if ((int)$usuario["id"] === $usuarioId) {
        $usuarioSeleccionado = $usuario;
        break;
    }
}

if ($usuarioSeleccionado === null) {
    $_SESSION["admin_error"] = "Usuario no encontrado.";
    header("Location: admin_usuarios.php");
    exit;
}

$historial = $fortuneService->obtenerHistorialUsuario($usuarioId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Historial de usuario</title>
</head>
<body class="historial-page">

<div class="container">

    <h1>Historial de <?php echo htmlspecialchars($usuarioSeleccionado["nombre"]); ?></h1>

    <p>
        <strong>Email:</strong>
        <?php echo htmlspecialchars($usuarioSeleccionado["email"]); ?>
    </p>

    <?php if (empty($historial)): ?>

        <p>Este usuario todavía no abrió ninguna galleta.</p>

    <?php else: ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Fecha y hora</th>
                    <th>Mensaje obtenido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $item): ?>
                    <tr>
                        <td>
                            <?php
                            $fecha = new DateTime($item["fecha_apertura"]);
                            echo htmlspecialchars($fecha->format("d/m/Y H:i:s"));
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($item["mensaje"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <br>

    <a href="admin_usuarios.php">Volver a usuarios</a>

    <br><br>

    <a href="admin_panel.php">Volver al panel</a>

</div>

</body>
</html>