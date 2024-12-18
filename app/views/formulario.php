<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8" />
    <link href="styles/styles_general.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="styles/stylelog.css" rel="stylesheet" type="text/css">
    <link rel="icon"  href="../img/logito.ico">
    <title>Eiffel Importaciones</title>
</head>
<body>
<div id="carcel" class="container">
    <div id="imagen" class="container-fluid">
        <img class="img-fluid" src="/img/logo.jpg">
    </div>
    <div class="container" id="page">
        <div id="login" class="container  d-flex justify-content-center align-items-center">
            <div class="row">
                <form id="dataForm" method="POST" action=<?=$action?>>
                    <?php if (isset($method)):?>
                        <input type="hidden" name="_method" value=<?=$method?>>
                    <?php endif ?>
                    <div class="form-group">
                        <div class="row">
                            <?php if ($mode=="registro"):?>
                                <label for="nombre">*Nombre:</label>
                                <input id="nombre" name="nombre" type="text" placeholder="nombre" value="<?=$name ?? ""?>"><br><br>
                            <?php endif?>
                        </div>
                        <div class="row">
                            <label for="email">*Correo electronico:</label>
                            <input id="email" name="email" type="email"  placeholder="email" value="<?=$email ?? ""?>"><br><br>
                        </div>
                        <div class="row">
                            <label for="contraseña">*Contraseña</label>
                            <input id="contraseña" name="contraseña" type="password" placeholder="contraseña" ><br><br>
                        </div>
                        <?php if ($mode=="registro"):?>
                            <div class="row">
                                <label for="repass">*Confirme la contraseña</label>
                                <input id="repass" name="repass" type="password" placeholder="confirme contraseña" ><br><br>
                            </div>
                            <div class="row">
                                <label for="direccion">Direccion</label>
                                <input id="direccion" name="direccion" type="text" placeholder="direccion de la empresa/local"><br><br>
                            </div>
                            <div class="row">
                                <label for="telefono">Numero de telefono</label>
                                <input id="telefono" name="telefono" type="tel" placeholder="telefono de contacto"><br><br>
                            </div>

                            <div class="row">
                                <label for="pregunta">Pregunta de Recuperación</label>
                                <p>Ingrese una pregunta personal que se usará en caso de perder la contraseña</p>
                                <input id="pregunta" name="pregunta" type="text" placeholder="Escriba una pregunta íntima"><br><br>
                            </div>

                            <div class="row">
                                <label for="respuesta">Respuesta de la Pregunta</label>
                                <p>Escriba la respuesta a la pregunta de seguridad de arriba</p>
                                <input id="respuesta" name="respuesta" type="text" placeholder="Escriba una respuesta que recuerde"><br><br>
                            </div>
                        <?php endif ?>
                    </div>
                    <hr>
                    <div class="button-group container" id="botones">

                    <div class="row">
                        <a href="/recuperarContraseniaCorreo">Recuperar Contraseña</a>
                    </div>
                        <div class="row">
                            <button class="botones">Confirmar <?=$mode?></button>
                        </div>
                        <div class="row">
                            <?php if ($mode=="login"):?> 
                                <button class="botones" type="button" onclick="location.href='/registro';">Registrarse</button>
                            <?php else:?>
                                <button class="botones" type="button" onclick="location.href='/login';">Iniciar Sesion</button>
                            <?php endif?>
                        </div>
                        <div class="row">
                            <button type="button" class="botones" onclick="location.href='/';">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="scripts/alertpopup.js"></script> <!-- Incluye el script aquí -->
<script>
    window.addEventListener("load", (event) => {
        <?php if (!empty($msg)): ?>
            let mensaje = <?= json_encode($msg) ?>;
            mostrarPopup(mensaje, false); // Cambia alert por mostrarPopup
        <?php endif; ?>
    });
    function validateForm(event) {
        event.preventDefault(); // Evita el envío del formulario hasta que las validaciones se completen

        const nombre = document.getElementById("nombre");
        const email = document.getElementById("email");
        const contraseña = document.getElementById("contraseña");
        const repass = document.getElementById("repass");
        const telefono = document.getElementById("telefono");
        const direccion = document.getElementById("direccion");
        const pregunta = document.getElementById("pregunta");
        const respuesta = document.getElementById("respuesta");
        
        const nombreRegex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;
        const emailRegex = /^[^\s@]+@gmail\.com$/;
        const contraseñaRegex = /^[A-Z][A-Za-z0-9]{7,}[0-9]+$/;
        const telefonoRegex = /^[0-9]+$/;

        let valid = true;
        let errorMsg = "";

        // Validar si los campos requeridos están completos
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
        if (direccion.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Direccion' no puede estar vacío.\n";
        }

        if (repass && repass.value.trim() === "") {
            valid = false;
            errorMsg += "El campo 'Confirmar Contraseña' no puede estar vacío.\n";
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

        // Validar número de teléfono (solo si se llena)
        if (telefono && telefono.value.trim() !== "" && !telefonoRegex.test(telefono.value)) {
            valid = false;
            errorMsg += "El número de teléfono solo puede contener números.\n";
        }

        // Validar dirección (opcional, pero debe tener al menos 5 caracteres si se llena)
        if (direccion && direccion.value.trim() !== "" && direccion.value.trim().length < 5) {
            valid = false;
            errorMsg += "Si se proporciona, la dirección debe tener al menos 5 caracteres.\N";
        }

        // Mostrar errores o enviar el formulario
        if (!valid) {
            mostrarPopup(errorMsg,false);
        } else {
            mostrarPopup("Formulario completado correctamente. Enviando datos...",true);
            document.getElementById("dataForm").submit(); // Enviar el formulario
        }
    }

    window.addEventListener("load", () => {
        document.getElementById("dataForm").addEventListener("submit", validateForm);
    });
</script>

</body>
</html>
