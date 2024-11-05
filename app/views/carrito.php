<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<link href="styles/styles_general.css" rel="stylesheet" type="text/css">
    <link href="styles/style5.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8" />
    <script src="scripts/script.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include "segments/header.php" ?>
    <?php include "segments/nav.php" ?>

    <div id="body-carrito">
        <div id="seccion-titulo" class="container-fluid float-start">
            <h1> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
  <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9zM1 7v1h14V7zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5"/>
</svg> CARRITO</h1>
            <hr>
        </div>

        <div id="tabla-prod" class="container justify-content-center align-items-center">
            <div class="row">
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Stock</th>
                    <th>Eliminar</th>
                </tr>

            </table>

        </div></div>

        <div id="cont-abajo" class="container">
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
</div>

 <?php include  "segments/footer.php" ?>
    <script src="scripts/carrito.js"></script>
   
</body>
</html>