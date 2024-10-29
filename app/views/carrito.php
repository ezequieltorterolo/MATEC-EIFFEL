<!DOCTYPE html>
<html lang="es">
<head>
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

            <script>
                // Obtener el carrito desde el localStorage
                let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                let carritoContainer = document.querySelector('#tabla-prod table');

                // Función para mostrar productos en la tabla
                function mostrarCarrito() {
                    if (carrito.length > 0) {
                        let productosActualizados = 0;
                        let totalGeneral = 0;

                        // Crear un array de promesas para obtener la información de todos los productos
                        let peticiones = carrito.map(producto => {
                            return fetch(`/prdinfo/${producto.id}`)
                                .then(response => response.json())
                                .then(prdinfo => {
                                    producto.info = prdinfo;
                                    return producto; // Retornar el producto actualizado
                                });
                        });

                        // Esperar a que todas las promesas se resuelvan
                        Promise.all(peticiones)
                            .then(productos => {
                                // Reiniciar el contenido de la tabla
                                carritoContainer.innerHTML = `
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Stock</th>
                                    </tr>`;
                                
                                // Mostrar todos los productos juntos
                                productos.forEach(function(producto, index) {
                                    agregarFila(producto, index);
                                    totalGeneral += calcularTotal(producto); // Calcular el total general
                                });

                                // Actualizar el total general en la interfaz
                                document.querySelector('#cont-total h2').innerText = `$${totalGeneral.toFixed(2)}`;
                            })
                            .catch(error => console.error('Error al cargar productos:', error));
                    } else {
                        carritoContainer.innerHTML += "<tr><td colspan='3'>El carrito está vacío</td></tr>";
                    }
                }
                

                // Función para agregar una fila con los datos del producto
                function agregarFila(producto, index) {
                    let prdinfo = producto.info;
                    let productRow = document.createElement('tr');
                    productRow.innerHTML = `
                        <td style="width:30%;">
                            <img src="img/${prdinfo.imagen}">
                            <a href="/producto?id=${prdinfo.id}"><p>${prdinfo.nombre}</p></a>
                            <span id="code">${prdinfo.id}</span>
                        </td>
                        <td>
                            <button onclick="quitar(${producto.id})">-</button>
                            <input type="number" id="cantidad_${producto.id}" value="${producto.cantidad}" min="1" max="${prdinfo.stock}" readonly>
                            <button onclick="agregar(${producto.id})">+</button>
                        </td>
                        <td id="total_${producto.id}">${calcularTotal(producto)}</td>
                        <td >${prdinfo.stock}</td>
                        <td><img onclick="borrarProducto(${index})" src="img/basura.svg" id="basura" style="cursor: pointer;"></td>

                        
                    `;
                    carritoContainer.appendChild(productRow);
                }

                // Función para calcular el total del producto basado en la cantidad y los precios
                function calcularTotal(producto) {
                    let prdinfo = producto.info;
                    let cantidad = producto.cantidad;
                    let precio = cantidad >= prdinfo.cantidadCaja ? prdinfo.precioCaja : prdinfo.precio;
                    return cantidad * precio;
                }

                // Función para actualizar el total de cada producto y el total general
                function total(id) {
                    let producto = carrito.find(producto => producto.id == id);
                    let totalProducto = calcularTotal(producto);
                    document.getElementById(`total_${id}`).innerText = totalProducto;

                    // Actualizar el total general
                    actualizarTotalGeneral();
                }

                // Función para actualizar el total general
                function actualizarTotalGeneral() {
                    let totalGeneral = 0;
                    carrito.forEach(producto => {
                        totalGeneral += calcularTotal(producto);
                    });
                    document.querySelector('#cont-total h2').innerText = `$${totalGeneral.toFixed(2)}`;
                }

                // Llamar a la función para mostrar el carrito
                mostrarCarrito();

                // Función para borrar producto
                function borrarProducto(index) {
                    carrito.splice(index, 1);
                    localStorage.setItem('carrito', JSON.stringify(carrito));
                    mostrarCarrito();
                }

                // Función para agregar cantidad
                function agregar(id) {
                    let producto = carrito.find(producto => producto.id == id);
                    let cantidadInput = document.getElementById(`cantidad_${id}`);
                    let cantidad = parseInt(cantidadInput.value);

                    if (cantidad < producto.info.stock) {
                        cantidad++;
                        cantidadInput.value = cantidad;
                        producto.cantidad = cantidad;
                        total(id);
                    }
                }

                // Función para quitar cantidad
                function quitar(id) {
                    let producto = carrito.find(producto => producto.id == id);
                    let cantidadInput = document.getElementById(`cantidad_${id}`);
                    let cantidad = parseInt(cantidadInput.value);

                    if (cantidad > 1) {
                        cantidad--;
                        cantidadInput.value = cantidad;
                        producto.cantidad = cantidad;
                        total(id);
                    }
                }
            </script>
        </div>

        <div id="cont-abajo">
            <div id="formulario-carrito">
                <form id="form-carrito" method="post">
                    Dirección:</br>
                    <input class="input-form" required type="text"></br>
                    Horario de entrega: </br>
                    <input class="input-form" required type="text"></br>
                    Aclaraciones: </br>
                    <textarea id="msg" type="message"></textarea>
                </form>
                <button id="conf">CONFIRMAR</button>
            </div>
            <div id="cont-total">
                <h1>TOTAL</h1>
                <h2>$0.00</h2> <!-- Inicialmente será $0.00 -->
            </div>
        </div>
    </div>
    <?php include  "segments/footer.php" ?>
</body>
</html>
