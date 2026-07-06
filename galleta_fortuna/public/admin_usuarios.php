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
    <button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>

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
<script src="js/toast.js"></script>

<?php if (isset($_SESSION["toast_success"])): ?>
<script>
mostrarToast(
    <?php echo json_encode($_SESSION["toast_success"]); ?>,
    "success"
);
</script>
<?php unset($_SESSION["toast_success"]); ?>
<?php endif; ?>

<?php if (isset($_SESSION["toast_error"])): ?>
<script>
mostrarToast(
    <?php echo json_encode($_SESSION["toast_error"]); ?>,
    "error"
);
</script>
<?php unset($_SESSION["toast_error"]); ?>
<?php endif; ?>



<script>
const darkToggle = document.getElementById("darkToggle");

if (localStorage.getItem("modoOscuro") === "activo") {
    document.body.classList.add("dark-mode");
    darkToggle.innerText = "☀️";
}

darkToggle.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("modoOscuro", "activo");
        darkToggle.innerText = "☀️";
    } else {
        localStorage.setItem("modoOscuro", "inactivo");
        darkToggle.innerText = "🌙";
    }
});
</script>


</body>
</html>