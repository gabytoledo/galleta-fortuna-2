<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/services/FortuneService.php";

$fortuneService = new FortuneService();
$galletas = $fortuneService->obtenerTodasLasGalletas();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>
<div class="container">

    <h1>Panel de Administración</h1>

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

    <h2>Registrar nuevo administrador</h2>

    <form action="procesar_admin.php" method="POST">

        <input
            type="text"
            name="nombre"
            placeholder="Nombre"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Contraseña"
            required
        >

        <button type="submit">
            REGISTRAR ADMIN
        </button>

    </form>

    <hr>

    <h2>Mensajes de la Fortuna</h2>

    <input
        type="text"
        id="buscadorGalletas"
        placeholder="🔍 Buscar galleta..."
        style="width:100%;padding:10px;margin-bottom:10px;border-radius:8px;border:1px solid #ccc;"
    >

    <p id="contadorBusqueda" style="color:#777;font-weight:bold;">
        Mostrando <?php echo count($galletas); ?> de <?php echo count($galletas); ?> galletas
    </p>

    <p id="sinResultados"
       style="display:none;color:#e17055;font-weight:bold;font-size:18px;">
        😕 No se encontraron galletas con ese texto.
    </p>

    <div style="max-height:400px;overflow-y:auto;padding-right:10px;">

        <?php if (empty($galletas)): ?>

            <p>No hay mensajes registrados.</p>

        <?php else: ?>

            <?php foreach ($galletas as $galleta): ?>

                <div class="galleta-item"
                     style="border:1px solid #ccc;padding:10px;margin-bottom:10px;border-radius:8px;">

                   <p class="galleta-texto">
                 <?php echo htmlspecialchars($galleta["texto"]); ?>
                </p>

                    <a href="editar_galleta.php?id=<?php echo (int)$galleta["id"]; ?>">
                        <button type="button">
                            ✏ EDITAR
                        </button>
                    </a>

                    <br><br>

                    <form action="eliminar_galleta.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo (int)$galleta["id"]; ?>"
                        >

                        <button
                            type="submit"
                            onclick="return confirm('¿Seguro que querés eliminar esta galleta?');"
                        >
                            🗑 ELIMINAR
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <br>

    <a href="logs.php">
         Ver logs de auditoría
    </a>

    <br><br>

    <a href="estadisticas.php">
         Ver estadísticas
    </a>

    <br><br>

    <a href="admin_usuarios.php">
         Ver usuarios e historial
    </a>

    <br><br>

    <a href="home.php">
         Volver al inicio
    </a>



    <br><br>

<a href="salud_sistema.php">
    🖥 Ver salud del sistema
</a>

</div>

<script>
const buscador = document.getElementById("buscadorGalletas");
const galletas = document.querySelectorAll(".galleta-item");
const contador = document.getElementById("contadorBusqueda");
const sinResultados = document.getElementById("sinResultados");

function escaparRegex(texto)
{
    return texto.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}

function actualizarBusqueda()
{
    const texto = buscador.value.toLowerCase().trim();

    let visibles = 0;

    galletas.forEach(function(galleta){

        const parrafo = galleta.querySelector(".galleta-texto");
        const textoOriginal = parrafo.textContent;
        const contenido = textoOriginal.toLowerCase();

        if(contenido.includes(texto))
        {
            galleta.style.display = "block";
            visibles++;

            if(texto !== "")
            {
                const regex = new RegExp("(" + escaparRegex(texto) + ")", "gi");

                parrafo.innerHTML = textoOriginal.replace(
                    regex,
                    "<mark>$1</mark>"
                );
            }
            else
            {
                parrafo.textContent = textoOriginal;
            }
        }
        else
        {
            galleta.style.display = "none";
            parrafo.textContent = textoOriginal;
        }
    });

    contador.innerHTML =
        "Mostrando <strong>" +
        visibles +
        "</strong> de <strong>" +
        galletas.length +
        "</strong> galletas";

    sinResultados.style.display = visibles === 0 ? "block" : "none";
}

buscador.addEventListener("input", actualizarBusqueda);
actualizarBusqueda();

<?php if (isset($_SESSION["admin_success"])): ?>
<script>
mostrarToast("<?php echo htmlspecialchars($_SESSION["admin_success"]); ?>", "success");
</script>
<?php unset($_SESSION["admin_success"]); ?>
<?php endif; ?>

<?php if (isset($_SESSION["admin_error"])): ?>
<script>
mostrarToast("<?php echo htmlspecialchars($_SESSION["admin_error"]); ?>", "error");
</script>
<?php unset($_SESSION["admin_error"]); ?>
<?php endif; ?>



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
</body>
</html>