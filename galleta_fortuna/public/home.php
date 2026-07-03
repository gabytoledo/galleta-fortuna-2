<?php
require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

/*
 * Limpiamos la última fortuna para que
 * fortune.php arranque con la galleta cerrada.
 */
unset($_SESSION["mensaje_fortuna"]);
unset($_SESSION["fecha_fortuna"]);
unset($_SESSION["clima_fortuna"]);
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Inicio - Galleta de la Fortuna</title>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
</head>
<body>

<div class="container">


<h1>Bienvenido, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></h1>

<p>Presioná el botón para abrir tu galleta de la fortuna.</p>

<a href="index.php?page=fortune">
    <button type="button">
        ABRE TU GALLETA
    </button>
</a>



<br><br>

<a href="subir_galleta.php">
    <button type="button">
        SUBIR GALLETA
    </button>
</a>

<?php if ($_SESSION["usuario_rol"] === "admin"): ?>
    <br><br>

    <a href="admin_panel.php">
        <button type="button">
            PANEL DE ADMIN
        </button>
    </a>
<?php endif; ?>

<br><br>

<a href="historial_galletas.php">
    Ver historial de galletas
</a>
<br><br>
<a href="mis_estadisticas.php">
    Ver mis estadísticas
</a>
<br><br>

<a href="mis_favoritas.php">
    Ver mis favoritas
</a>


<br><br>
<a href="logout.php">
    Cerrar sesión
</a>
</div>

</body>
</html>
