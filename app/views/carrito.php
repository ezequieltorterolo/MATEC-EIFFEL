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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="styles/alertpopup.css" rel="stylesheet" type="text/css">
    <link href="styles/modal.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include "segments/header.php" ?>
    <?php include "segments/nav.php" ?>

    <div id="body-carrito">
        <div id="parte-titulo" class="container-fluid"> <!-- Porque borraste???? Me rompiste la responsividad-->
            <h1>CARRITO</h1>
            <hr>
        </div>


<br>
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
        <?php  if (isset($_SESSION["usuario"])){

            $valorDirent = $_SESSION['usuario']['direccion'];

        
        }else{
            $valorDirent = "";
        }
           ?>         

        <div id="cont-abajo" class="container">
    <div id="formulario-carrito">
    <form id="form-carrito" method="post" onsubmit="carrito_confirmar(event)">
    Dirección:<br>
    <input id="dirent" class="input-form" required type="text" value="<?php echo $valorDirent ?>"><br>
    Horario de entrega:</br>
    <input id="horaent" class="input-form" required type="text"><br>
    Aclaraciones:<br>
    <textarea id="msg" ></textarea><br>
    <button type="submit">CONFIRMAR</button>
</form>
    </div>
    <div id="cont-total">
        <h1>TOTAL</h1>
        <h2>$0.00</h2>
    </div>
</div>
</div>
   
       <script src="scripts/alertpopup.js"></script>
    <?php include  "segments/footer.php" ?>
    <script src="scripts/carrito.js"></script>
</body>
</html>