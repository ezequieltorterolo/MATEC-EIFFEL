 


 function mostrarPopup(mensaje, esExito) {
    // Crear el contenedor del popup si no existe
    let popup = document.getElementById("popup-alerta");
    if (!popup) {
        popup = document.createElement("div");
        popup.id = "popup-alerta";
        
        // Agregar estilos para que el popup esté oculto al principio
        popup.style.position = "fixed";
        popup.style.bottom = "20px";
        popup.style.left = "50%";
        popup.style.transform = "translateX(-50%)";
        popup.style.padding = "15px 30px";
        popup.style.borderRadius = "5px";
        popup.style.color = "#fff";
        popup.style.fontSize = "16px";
        popup.style.textAlign = "center";
        popup.style.zIndex = "1000";
        popup.style.opacity = "0";
        popup.style.visibility = "hidden";
        popup.style.transition = "opacity 0.3s ease, visibility 0.3s ease";
        
        document.body.appendChild(popup);
    }

    // Establecer el mensaje
    popup.textContent = mensaje;

    // Cambiar el estilo según el tipo de alerta
    if (esExito) {
        popup.style.backgroundColor = "#4CAF50"; // Verde para éxito
    } else {
        popup.style.backgroundColor = "#f44336"; // Rojo para error
    }

    // Mostrar el popup
    popup.style.opacity = "1";
    popup.style.visibility = "visible";

    // Ocultar el popup después de 3 segundos
    setTimeout(() => {
        popup.style.opacity = "0";
        popup.style.visibility = "hidden";
    }, 3000);
}

/* Estilos para el popup */
