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

<script> let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

let carritoContainer = document.getElementById('tabla-prod');

if (carrito.length > 0) {
            carrito.forEach(function(producto) {
                // Crear elementos para mostrar cada producto
                let productDiv = document.createElement('tr');
                productDiv.innerHTML = `



    <td style="width:30%;">     
     <img id="imagen" src="img/${producto.imagen}"><p>${producto.nombre} </p> <span id="code"> codigo de producto</span></td>
    <td>100 x 1</td>
    <td><div id="quitaragregar">
                 <button onclick="quitar()">-</button>
                <input type="number" id="cantidad" value="${producto.cantidad}" min="1" max="99" readonly>
                <button onclick="agregar()">+</button>    
            </div></td>
    <td> 100 x 1 </td>
    
<td> <img src="img/basura.svg" id="basura"> </img> </td>
  


   

`  ;

carritoContainer.appendChild(productDiv);

     });
        } else {
            carritoContainer.innerHTML = "<p>El carrito está vacío</p>";
        }
    </script>

</div>

</table>



    </div>
</body> 