<!DOCTYPE html>
<html lang="es">
<head>
    <link href="styles/style5.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8" />
    <script src="scripts/script.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="styles/styles_general.css" rel="stylesheet" type="text/css">
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include "segments/header.php" ?>
    <?php include "segments/nav.php" ?>

    <div id="body-carrito">
        <div id="seccion-titulo">
            <h1>CARRITO</h1>
            <hr>
        </div>

        <div id="tabla-prod">
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Stock</th>
                </tr>
            </table>

        </div>

        <div id="cont-abajo">
    <div id="formulario-carrito">
    <form id="form-carrito" method="post" onsubmit="carrito_confirmar(event)">
    Dirección:</br>
    <input id="dirent" class="input-form" required type="text"></br>
    Horario de entrega:</br>
    <input id="horaent" class="input-form" required type="text"></br>
    Aclaraciones:</br>
    <textarea id="msg" ></textarea></br>
    <button type="submit">CONFIRMAR</button>
</form>
    </div>
    <div id="cont-total">
        <h1>TOTAL</h1>
        <h2>$0.00</h2>
    </div>
</div>

    <script src="scripts/carrito.js"></script>
</body>
</html>