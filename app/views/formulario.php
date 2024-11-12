<html>
<head>
<title><?=getenv("APP_NAME")?></title>
<link rel="stylesheet" href="/static/css/user_form.css">
</head>
<body>
    <div class="container-fluid" id="page">
        <div id="title" class="container">
            <h1><?= $title ?? ucfirst($mode) . " User" ?></h1>
            <hr>
        </div>

        <div id="login" class="container d-flex justify-content-center align-items-center">
            <div class="row">
                <form id="dataForm" method="POST" action=<?= $action ?>>

                    <?php if (isset($method)): ?>
                        <input type="hidden" name="_method" value=<?= $method ?>>
                    <?php endif ?>

                    <div class="form-group">
                        <div class="row">
                            <?php if ($mode == "registro"): ?>
                                <label for="nombre">Nombre:</label>
                                <input id="nombre" name="nombre" type="text" placeholder="nombre" value="<?= $name ?? "" ?>" required><br><br>
                            <?php endif ?>
                        </div>
                        <div class="row">
                            <label for="email">Email:</label>
                            <input id="email" name="email" type="email" placeholder="email" value="<?= $email ?? "" ?>" required><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <label for="contraseña">Contraseña:</label>
                        <input id="contraseña" name="contraseña" type="password" placeholder="contraseña" required><br><br>
                    </div>
                    <?php if ($mode == "registro"): ?>
                        <div class="row">
                            <label for="repass">Confirme la Contraseña:</label>
                            <input id="repass" name="repass" type="password" placeholder="confirme contraseña" required><br><br>
                        </div>
                        <div class="row">
                            <label for="direccion">Direccion:</label>
                            <input id="direccion" name="direccion" type="text" placeholder="direccion de la empresa/local"><br><br>
                        </div>
                        <div class="row">
                            <label for="telefono">Telefono:</label>
                            <input id="telefono" name="telefono" type="tel" placeholder="telefono de contacto"><br><br>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>

        <div class="button-group container" id="botones">
            <div class="row">
                <button class="btn btn-primary">Confirmar <?= $mode ?></button>
                <?php if ($mode == "login"): ?> 
                    <p><a href="/registro">Registrarse</a></p>
                <?php else: ?>
                    <p><a href="/login">Iniciar Sesion</a></p>
                <?php endif ?>
            </div>
            <div class="row">
                <button type="button" class="btn btn-primary" onclick="location.href='/';">Cancelar</button>
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
    </script>
</body>
</html>
