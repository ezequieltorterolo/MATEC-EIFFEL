<style>
    body {
        background-color: #ffffff;
        text-align: justify;
    }

    .seccion-titulo {
        margin-bottom: 20px;
        width: fit-content;
    }

    #seccion-subtitulo {
        margin-left: 20px;
        margin-bottom: 10px;
        width: fit-content;
    }

    #seccion-subtitulo hr {
        margin-top: 10px;
    }

    hr {
        width: 90%;
        margin-top: 20px;
    }

    .body-info {
        margin: 20px;
        margin-bottom: 50px;
    }

    .imagen-margen {
        background-image: url(../img/foto-empresa-eiffel.jpg);
        background-position: center;
        margin: 0px;
        width: 100%;
        height: 200px;
    }

    #cont-todo {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    #seccion-imagen img {
        width: 600px;
    }

    .lista-pasos {
        margin-left: 20px;
        margin-top: 10px;
        width: 80%;
    }

    .lista-pasos li {
        margin-bottom: 5px;
        padding: 5px;
    }

    #title {
        margin-left: 5px;
        margin-bottom: 20px;
        width: fit-content;
    }

    #page {
        margin-bottom: 29px;
        overflow: hidden;
    }

    label {
        margin-right: 10px;
        font-size: 19px;
        font-weight: bold;
    }

    .btn-primary {
        border: none;
        height: fit-content;
        max-height: 90px;
        text-align: center;
        background-color: #253141;
        color: #ffffff;
        font-size: 17px;
        transition: all 1s;
    }

    input {
        width: 100%;
        height: 50px;
    }

    #login {
        width: 50%;
        padding: 10px;
        margin: auto;
        margin-bottom: 2%;
    }

    #botones {
        margin: auto;
        width: 30%;
    }

    .container-fluid {
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
</style>

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
