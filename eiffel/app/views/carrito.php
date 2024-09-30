<!DOCTYPE html>
<html>
<head> 
    <link href="styles/style5.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8" />
    <script src="scripts/script.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php" ?>


    <div id="body-carrito">
    <div id="seccion-titulo">
        <h1>CARRITO</h1>
        <hr>
    </div>


<div id="tabla-prod">
<table>
  <tr>
    <th>Producto</th>
    <th>Precio x Unidad</th>
    <th>Cantidad</th>
    <th>Total</th>
  </tr>
  <tr>
    <td style="width:30%;">     
    <img src="img/placeholder.png"><p>Soy un producto :D</p> <span id="code"> codigo de producto</span></td>
    <td>100 x 1</td>
    <td><div id="quitaragregar">
                 <button onclick="quitar()">-</button>
                <input type="number" id="cantidad" value="1" min="1" max="99" readonly>
                <button onclick="agregar()">+</button>    
            </div></td>
    <td> 100 x 1 </td>
    
<td> <img src="img/basura.svg" id="basura"> </img> </td>
  </tr>
  <tr>
  <td style="width:30%;">     
    <img src="img/placeholder.png"><p>Soy un producto :D</p> <span id="code"> codigo de producto</span></td>
    <td>100 x 1</td>
    <td><div id="quitaragregar">
                 <button onclick="quitar()">-</button>
                <input type="number" id="cantidad" value="1" min="1" max="99" readonly>
                <button onclick="agregar()">+</button>    
            </div></td>
    <td> 100 x 1 </td>
<td> <img src="img/basura.svg" id="basura"> </img> </td>
</tr>
</table>

</div>





    </div>
</body>