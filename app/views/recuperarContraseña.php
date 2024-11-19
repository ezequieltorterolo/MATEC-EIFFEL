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
                    <form id="dataForm" method="POST" action=<?= $action ?>>
                        <?php if (isset($method)): ?>
                            <input type="hidden" name="_method" value=<?= $method ?>>
                        <?php endif; ?>
                        <div class="form-group">
                            <?php if (isset($mode)): ?>
                                <input type="hidden" name="modo" value=<?= $mode ?>>
                            <?php endif ?>

                            <?php if ($mode == "email"): ?>
                                <div class="row">
                                    <label for="email">Correo electronico:</label>
                                    <input id="email" name="email" type="email" placeholder="email" value="<?= $email ?? "" ?>"><br><br>
                                </div>
                            <?php endif; ?>
                            <?php if ($mode == "nueva contraseña"): ?>
                                <div class="row">
                                    <label for="contraseña">Contraseña</label>
                                    <input id="contraseña" name="contraseña" type="password" placeholder="contraseña"><br><br>
                                </div>

                                <div class="row">
                                    <label for="repass">Confirme la contraseña</label>
                                    <input id="repass" name="repass" type="password" placeholder="confirme contraseña"><br><br>
                                </div>
                            <?php endif; ?>
                            <?php if ($mode == "pregunta"): ?>
                                <div class="row">
                                    <label for="pregunta">Pregunta de Recuperación</label>
                                    <p><?= $usuario["pregunta"] ?></p>
                                </div>

                                <div class="row">
                                    <label for="respuesta">Respuesta</label>
                                    <input id="respuesta" name="respuesta" type="text" placeholder="Respuesta"><br><br>
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                            <div class="row">
                                <button class="botones">Confirmar <?= $mode ?></button>
                            </div>

                            <div class="row">
                                <button type="button" class="botones" onclick="location.href='/login';">Cancelar</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts/alertpopup.js"></script>
    <script>
        window.addEventListener("load", (event) => {
            <?php if (!empty($msg)): ?>
                let mensaje = <?= json_encode($msg) ?>;
                mostrarPopup(mensaje, false);
            <?php endif; ?>
        });
    </script>
</body>

</html>