<?php
require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::start();

if (isset($_SESSION["usuario_id"])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
     <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <meta charset="UTF-8">
    <title>Registro - Galleta de la Fortuna</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h1>Galleta de la Fortuna</h1>
    <h2>Registro</h2>

    <?php if (isset($_SESSION["error_registro"])): ?>
        <p style="color:red; font-weight:bold;">
            <?php echo $_SESSION["error_registro"]; ?>
        </p>
        <?php unset($_SESSION["error_registro"]); ?>
    <?php endif; ?>

    <form action="procesar_registro.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre"><br><br>

        <label>Email:</label><br>
        <input type="text" name="email"><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Registrarme</button>
    </form>

    <p>
        ¿Ya tenés cuenta?
        <a href="login.php">Iniciar sesión</a>
    </p>

</div>

</body>
</html>