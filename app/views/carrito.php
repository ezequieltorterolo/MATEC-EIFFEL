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
            <th>Cantidad</th>
            <th>Total</th>
         </tr>
</table>


<script>
    // Obtener el carrito desde el localStorage
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    let carritoContainer = document.querySelector('#tabla-prod table');

    // Función para mostrar productos en la tabla
    function mostrarCarrito() {
        carritoContainer.innerHTML = `
            <tr> 
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
               
            </tr>`;
        
        if (carrito.length > 0) {
            carrito.forEach(function(producto, index) {
                // Crear una fila para cada producto
                let productRow = document.createElement('tr');
                productRow.innerHTML = `
                    <td style="width:30%;">
                        <img src="img/${producto.imagen}">
                        <p>${producto.nombre}</p> 
                        <span id="code"> código de producto</span>
                    </td>
                    <td><button onclick="quitar()">-</button>
                  <input type="number" id="cantidad" value="${producto.cantidad}" min="1" max="99" readonly>
                <button onclick="agregar()">+</button> </td>
                    <td>${producto.total}</td>
                    <td><img onclick="borrarProducto(${index})" src="img/basura.svg" id="basura" style="cursor: pointer;"></td>
                `;

                carritoContainer.appendChild(productRow);
            });
        } else {
            carritoContainer.innerHTML += "<tr><td colspan='4'>El carrito está vacío</td></tr>";
        }
    }

    // Función para borrar producto
    function borrarProducto(index) {
        // Eliminar el producto del array
        carrito.splice(index, 1);

        // Actualizar el localStorage
        localStorage.setItem('carrito', JSON.stringify(carrito));

        // Recargar la tabla
        mostrarCarrito();
    }

    // Mostrar el carrito al cargar la página
    mostrarCarrito();
    </script>

    <script> function agregar() {
    let cantidadInput = document.getElementById('cantidad');
    let cantidad = parseInt(cantidadInput.value);

    // Aumentar la cantidad solo si es menor que el máximo
    if (cantidad < parseInt(cantidadInput.max)) {
        cantidadInput.value = cantidad + 1; // Actualizar el valor del input
    }
}

function quitar() {
    let cantidadInput = document.getElementById('cantidad');
    let cantidad = parseInt(cantidadInput.value);

    // Disminuir la cantidad solo si es mayor que el mínimo
    if (cantidad > parseInt(cantidadInput.min)) {
        cantidadInput.value = cantidad - 1; // Actualizar el valor del input
    
        
    }
}
   
   </script>
</div>

<div id="cont-abajo">
    <div id="formulario-carrito">
        <form id="form-carrito" method="post">
            Dirección:</br>
            <input class="input-form" required  type="text"></br>
            Horario de entrega: </br>
            <input class="input-form" required type="text"></br>
            Aclaraciones: </br>
            <textarea id="msg" type="message"></textarea>
        </form>
        <button id="conf" >CONFIRMAR</button>
    </div>
    <div id="cont-total">
        <h1>TOTAL</h1>
        <h2>$xxxx</h2>
    </div>
</div>


</div>
</body>