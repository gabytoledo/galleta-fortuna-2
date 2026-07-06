<?php
require_once __DIR__ . "/../app/core/SessionManager.php";

SessionManager::requireAdmin();
$contenidoLogs = $_SESSION["contenido_logs"] ?? "No hay logs para mostrar.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Logs del sistema</title>
</head>
<body class="historial-page">
    <button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>

<div class="container">

    <h1>Logs de auditoría</h1>

    <pre style="text-align: left; white-space: pre-wrap;">
<?php echo htmlspecialchars($contenidoLogs); ?>
    </pre>

    <br>
<a href="index.php?page=admin">

    <br><br>

   <a href="index.php?page=home">

    <br><br>

    <a href="logout.php">Cerrar sesión</a>

</div>

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

</body>
</html>