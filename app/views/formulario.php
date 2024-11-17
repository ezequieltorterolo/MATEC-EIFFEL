<!DOCTYPE html>
<html lang="es">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<meta charset="UTF-8" />
<link href="styles/styles_general.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="styles/stylelog.css" rel="stylesheet" type="text/css">
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
                        <?php endif ?>
                    </div>
                    <hr>
                    <div class="button-group container" id="botones">
                        <div class="row">
                            <button class="botones">Confirmar <?=$mode?></button>
                            <?php if ($mode=="login"):?> 
                                <p><a href="/registro">Registrarse</a></p>
                            <?php else:?>
                                <p><a href="/login">Iniciar Sesion</a></p>
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
<script>
    window.addEventListener("load", (event) => {
      <?php if (!empty($msg)): ?>
        let mensaje = <?= json_encode($msg) ?>;
        alert(mensaje);
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
        
        const nombreRegex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;
        const emailRegex = /^[^\s@]+@gmail\.com$/;
        const contraseñaRegex = /^[A-Z][A-Za-z0-9]{7,}[0-9]+$/;
        const telefonoRegex = /^[0-9]+$/;

        let valid = true;
        let errorMsg = "";

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

        if (nombre && nombre.value && !nombreRegex.test(nombre.value)) {
            valid = false;
            errorMsg += "El nombre solo puede contener letras.\n";
        }

        if (email.value && !emailRegex.test(email.value)) {
            valid = false;
            errorMsg += "El correo debe ser una dirección válida de Gmail (@gmail.com).\n";
        }

        if (contraseña.value && !contraseñaRegex.test(contraseña.value)) {
            valid = false;
            errorMsg += "La contraseña debe comenzar con una mayúscula, tener al menos 8 caracteres y al menos un número.\n";
        }

        if (repass && contraseña.value !== repass.value) {
            valid = false;
            errorMsg += "Las contraseñas no coinciden.\n";
        }

        if (telefono && telefono.value.trim() !== "" && !telefonoRegex.test(telefono.value)) {
            valid = false;
            errorMsg += "El número de teléfono solo puede contener números.\n";
        }

        if (direccion && direccion.value.trim() !== "" && direccion.value.trim().length < 5) {
            valid = false;
            errorMsg += "Si se proporciona, la dirección debe tener al menos 5 caracteres.\n";
        }

        if (!valid) {
            alert("Errores en el formulario:\n" + errorMsg);
        } else {
            alert("Formulario completado correctamente. Enviando datos...");
            document.getElementById("dataForm").submit(); 
        }
    }

    window.addEventListener("load", () => {
        document.getElementById("dataForm").addEventListener("submit", validateForm);
    });
</script>
</body>
</html>
