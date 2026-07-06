function mostrarToast(mensaje, tipo = "info") {
    let toast = document.getElementById("toast-global");

    if (!toast) {
        toast = document.createElement("div");
        toast.id = "toast-global";
        toast.className = "toast-global";
        document.body.appendChild(toast);
    }

    toast.innerText = mensaje;
    toast.className = "toast-global show " + tipo;

    setTimeout(function () {
        toast.classList.remove("show");
    }, 3000);
}