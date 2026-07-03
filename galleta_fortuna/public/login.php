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
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Login - Galleta de la Fortuna</title>
</head>
<body>
    <div class="container">
    <h1>Galleta de la Fortuna</h1>
    <h2>Iniciar sesión</h2>

  <?php if (isset($_SESSION["error"])): ?>
    <p style="color:red;">
        <?php echo $_SESSION["error"]; ?>
    </p>
    <?php unset($_SESSION["error"]); ?>
    <?php endif; ?>
    <?php if (isset($_GET["success"])): ?>
        <p style="color:green;">Registro exitoso. Ahora podés iniciar sesión.</p>
    <?php endif; ?>

    <form action="procesar_login.php" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ingresar</button>
    </form>

    <p>
        ¿No tenés cuenta?
        <a href="register.php">Registrate acá</a>
    </p>
    </div>

</body>
</html>