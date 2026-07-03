<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/services/UserService.php";

$userService = new UserService();
$usuarios = $userService->obtenerTodosLosUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Usuarios</title>
</head>
<body class="historial-page">

<div class="container">

    <h1>Usuarios registrados</h1>

    <?php if (isset($_SESSION["admin_success"])): ?>
        <p style="color:green;font-weight:bold;">
            <?php echo htmlspecialchars($_SESSION["admin_success"]); ?>
        </p>
        <?php unset($_SESSION["admin_success"]); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION["admin_error"])): ?>
        <p style="color:red;font-weight:bold;">
            <?php echo htmlspecialchars($_SESSION["admin_error"]); ?>
        </p>
        <?php unset($_SESSION["admin_error"]); ?>
    <?php endif; ?>

    <?php if (empty($usuarios)): ?>
        <p>No hay usuarios registrados.</p>
    <?php else: ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol actual</th>
                    <th>Cambiar rol</th>
                    <th>Historial</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["rol"]); ?></td>
                        <td>
                            <?php if ((int)$usuario["id"] === (int)$_SESSION["usuario_id"]): ?>
                                No editable
                            <?php else: ?>
                                <form action="actualizar_rol_usuario.php" method="POST">
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo (int)$usuario["id"]; ?>"
                                    >

                                    <select name="rol" required>
                                        <option value="usuario" <?php echo $usuario["rol"] === "usuario" ? "selected" : ""; ?>>
                                            usuario
                                        </option>
                                        <option value="admin" <?php echo $usuario["rol"] === "admin" ? "selected" : ""; ?>>
                                            admin
                                        </option>
                                    </select>

                                    <button type="submit">
                                        Guardar
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="admin_historial_usuario.php?id=<?php echo (int)$usuario["id"]; ?>">
                                Ver historial
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <br>

    <a href="admin_panel.php">Volver al panel</a>

</div>

</body>
</html>