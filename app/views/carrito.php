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
                // Crear una fila para cada producto con IDs únicos
                let productRow = document.createElement('tr');
                productRow.innerHTML = `
                    <td style="width:30%;">
                        <img src="img/${producto.imagen}">
                        <a href="/producto?id=${producto.id}"><p>${producto.nombre}</p></a>
                        <span id="code"> código de producto</span>
                    </td>
                    <td>
                        <button onclick="quitar(${producto.id})">-</button>
                        <input type="number" id="cantidad_${producto.id}" value="${producto.cantidad}" min="1" max="${producto.stock}" readonly>
                        <button onclick="agregar(${producto.id})">+</button>
                    </td>
                    <td id="total_${producto.id}">${producto.total}</td>
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

    // Función para actualizar el total general del carrito
    function actualizarTotalCarrito() {
        let totalGeneral = carrito.reduce((acc, producto) => acc + producto.total, 0);
        document.querySelector("#cont-total h2").innerText = `$${totalGeneral}`;
    }

    // Mostrar el carrito al cargar la página
    mostrarCarrito();
    actualizarTotalCarrito();

    // Función para agregar cantidad
    function agregar(id) {
        let producto = carrito.find(producto => producto.id == id);
        let cantidadInput = document.getElementById(`cantidad_${id}`);
        let cantidad = parseInt(cantidadInput.value);
        
        // Aumentar la cantidad solo si es menor que el stock disponible
        if (cantidad < producto.stock) {
            cantidad++;
            cantidadInput.value = cantidad;
            producto.cantidad = cantidad;

            // Actualizar el total del producto
            total(id);
        }
    }

    // Función para quitar cantidad
    function quitar(id) {
        let producto = carrito.find(producto => producto.id == id);
        let cantidadInput = document.getElementById(`cantidad_${id}`);
        let cantidad = parseInt(cantidadInput.value);
        
        // Disminuir la cantidad solo si es mayor que 1
        if (cantidad > 1) {
            cantidad--;
            cantidadInput.value = cantidad;
            producto.cantidad = cantidad;

            // Actualizar el total del producto
            total(id);
        }
    }

    // Función para actualizar el total de cada producto
    function total(id) {
        let producto = carrito.find(producto => producto.id == id);
        let cantidad = producto.cantidad;
        let total;

        // Calcular el total dependiendo de la cantidad
        if (cantidad < producto.cantidadCaja) {
            total = cantidad * producto.precio;
        } else {
            total = cantidad * producto.precioCaja;
        }

        producto.total = total;

        // Actualizar el total en la tabla
        document.getElementById(`total_${id}`).innerText = total;

        // Actualizar el total general del carrito
        actualizarTotalCarrito();

        // Actualizar el localStorage
        localStorage.setItem('carrito', JSON.stringify(carrito));
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