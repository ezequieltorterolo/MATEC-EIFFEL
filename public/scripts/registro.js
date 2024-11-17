
    function validateForm(event) {
        event.preventDefault(); // Evita el envío del formulario hasta que las validaciones se completen

        const nombre = document.getElementById("nombre");
        const email = document.getElementById("email");
        const contraseña = document.getElementById("contraseña");
        const repass = document.getElementById("repass");
        const telefono = document.getElementById("telefono");
        const direccion = document.getElementById("direccion");
        
        const nombreRegex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;
        const emailRegex = /^[^\s@]+@gmail\.com$/;
        const contraseñaRegex = /^[A-Z][A-Za-z0-9]{7,}[0-9]+$/;
        const telefonoRegex = /^[0-9]+$/;

        let valid = true;
        let errorMsg = "";

        // Validar si todos los campos requeridos están completos
        if (nombre && nombre.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Nombre' no puede estar vacío.\n";
        }
        if (email.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Correo Electrónico' no puede estar vacío.\n";
        }
        if (contraseña.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Contraseña' no puede estar vacío.\n";
        }
        if (repass && repass.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Confirmar Contraseña' no puede estar vacío.\n";
        }
        if (telefono && telefono.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Teléfono' no puede estar vacío.\n";
        }
        if (direccion && direccion.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Dirección' no puede estar vacío.\n";
        }

        // Validar nombre
        if (nombre && nombre.value && !nombreRegex.test(nombre.value)) {
            valid = false;
            errorMsg += "El nombre solo puede contener letras.\n";
        }

        // Validar correo electrónico
        if (email.value && !emailRegex.test(email.value)) {
            valid = false;
            errorMsg += "El correo debe ser una dirección válida de Gmail (@gmail.com).\n";
        }

        // Validar contraseña
        if (contraseña.value && !contraseñaRegex.test(contraseña.value)) {
            valid = false;
            errorMsg += "La contraseña debe comenzar con una mayúscula, tener al menos 8 caracteres y al menos un número.\n";
        }

        // Confirmar contraseña
        if (repass && contraseña.value !== repass.value) {
            valid = false;
            errorMsg += "Las contraseñas no coinciden.\n";
        }

        // Validar número de teléfono
        if (telefono && telefono.value && !telefonoRegex.test(telefono.value)) {
            valid = false;
            errorMsg += "El número de teléfono solo puede contener números.\n";
        }

        // Mostrar errores o enviar el formulario
        if (!valid) {
            alert("Errores en el formulario:\n" + errorMsg);
        } else {
            alert("Formulario completado correctamente. Enviando datos...");
            document.getElementById("dataForm").submit(); // Enviar el formulario
        }
    }

    window.addEventListener("load", () => {
        document.getElementById("dataForm").addEventListener("submit", validateForm);
    });