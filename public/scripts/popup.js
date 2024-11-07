
        function popUpOpen() {
            document.getElementById("myModal").style.display = "flex";
        }

        function cerrarModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Cerrar el modal si el usuario hace clic fuera del contenido
        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target === modal) {
                cerrarModal();
            }
        }
  