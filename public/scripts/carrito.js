var carrito = JSON.parse(localStorage.getItem('carrito')) || [];
let carritoContainer = document.querySelector('#tabla-prod table');


function carrito_confirmar(event) {
    


    event.preventDefault();
        

    // Obtener los elementos del formulario
    const dirent = document.getElementById("dirent").value;
    const horaent = document.getElementById("horaent").value;
    const aclaraciones = document.getElementById("msg").value;

    if (typeof carrito === 'undefined' || !Array.isArray(carrito)) {
        console.error("Error: 'carrito' no está definido o no es un array.");
        alert("El carrito no está definido correctamente.");
        return;
    }

    // Construir el objeto reserva
    let reserva = {
        "dirent": dirent,
        "horaent": horaent,
        "aclaraciones": aclaraciones,
        "carrito": carrito
    };

    fetch("carrito_confirmar", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(reserva)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarPopup(data.message,true);// Mensaje de éxito
            localStorage.setItem('carrito', JSON.stringify([])); // Vaciar el carrito
            window.location.reload(); // Recargar la página
        } else {
            mostrarPopup(data.error, false); // Mostrar mensaje de error
            window.location.reload();
        }
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        mostrarPopup(data.error, false);
    });
}

function mostrarCarrito() {
    carritoContainer.innerHTML = `
        <tr>
            <th id="pro">Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Stock</th>
            <th>Eliminar</th>
        </tr>`;

    if (carrito.length > 0) {
        let totalGeneral = 0;

        let peticiones = carrito.map(producto => {
            return fetch(`/prdinfo/${producto.id}`)
                .then(response => response.json())
                .then(prdinfo => {
                    producto.info = prdinfo;
                    return producto;
                });
        });

        Promise.all(peticiones)
            .then(productos => {
                productos.forEach(function(producto, index) {
                    agregarFila(producto, index);
                    totalGeneral += calcularTotal(producto);
                });

                document.querySelector('#cont-total h2').innerText = `$${totalGeneral.toFixed(2)}`;
                localStorage.setItem('carrito', JSON.stringify(carrito));
            })
            .catch(error => console.error('Error al cargar productos:', error));
    } else {
        carritoContainer.innerHTML += "<tr><td colspan='4'>El carrito está vacío</td></tr>";
        document.querySelector('#cont-total h2').innerText = "$0.00";

        document.getElementById("cont-abajo").style.display = "none";
        document.getElementById("tabla-prod").style.marginBottom = "200px";
    }
}

function agregarFila(producto, index) {
    let prdinfo = producto.info;
    let productRow = document.createElement('tr');
    let stockIndicator = "";

    // Convertir cantidad y stock a números
    let cantidad = parseInt(producto.cantidad, 10);
    let stock = parseInt(prdinfo.stock, 10);

    if (stock === 0) {
        stockIndicator = `<span style="color:red;">No queda stock ${stock}</span>`;
    } else if (cantidad > stock) {
        producto.cantidad = stock;
        stockIndicator = `<span style="color:red;">El stock ha bajado a ${stock}</span>`;
    } else if (stock <= 5) {
        stockIndicator = `<span style="color:red;">Solo quedan ${stock} unidades</span>`;
    } else if (cantidad === stock) {
        stockIndicator = `<span style="color:orange;">Stock limitado ${stock}</span>`;
    } else {
        stockIndicator = `<span style="color:green;">Stock alto</span>`;
    }

    productRow.innerHTML = `
        <td style="width:30%;">
            <img src="img/${prdinfo.imagen}">
            <p id="pnombre"><a href="/producto?id=${prdinfo.id}" style="color:black;">${prdinfo.nombre}</a></p>
            <span id="code">Código de producto: ${prdinfo.id}</span>
        </td>
        <td>
            <p>
                <button onclick="quitar(${producto.id})">-</button>
                <input type="number" id="cantidad_${producto.id}" value="${producto.cantidad}" min="1" max="${stock}" readonly>
                <button onclick="agregar(${producto.id})">+</button>
            </p>
        </td>
        <td id="total_${producto.id}">${calcularTotal(producto).toFixed(2)}</td>
         <td>${stockIndicator}</td>
        <td><button><img onclick="borrarProducto(${index})" src="img/basura.svg" id="basura"></button></td>
       
    `;
    carritoContainer.appendChild(productRow);
}


function calcularTotal(producto) {
    let prdinfo = producto.info;
    let cantidad = producto.cantidad;
    let precio = cantidad >= prdinfo.cantidadCaja ? prdinfo.precioCaja : prdinfo.precio;
    return cantidad * precio;
}

function total(id) {
    let producto = carrito.find(producto => producto.id == id);
    let totalProducto = calcularTotal(producto);
    document.getElementById(`total_${id}`).innerText = totalProducto.toFixed(2);
    actualizarTotalGeneral();
}

function actualizarTotalGeneral() {
    let totalGeneral = 0;
    carrito.forEach(producto => {
        totalGeneral += calcularTotal(producto);
    });
    document.querySelector('#cont-total h2').innerText = `$${totalGeneral.toFixed(2)}`;
}

mostrarCarrito();

function borrarProducto(index) {
    carrito.splice(index, 1);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    mostrarCarrito();
    mostrarCantidadP();
}

function agregar(id) {
    let producto = carrito.find(producto => producto.id == id);
    let cantidadInput = document.getElementById(`cantidad_${id}`);
    let cantidad = parseInt(cantidadInput.value);

    if (cantidad < producto.info.stock) {
        cantidad++;
        cantidadInput.value = cantidad;
        producto.cantidad = cantidad;
        localStorage.setItem('carrito', JSON.stringify(carrito));
        total(id);
        agregarFila();

    }
}

function quitar(id) {
    let producto = carrito.find(producto => producto.id == id);
    let cantidadInput = document.getElementById(`cantidad_${id}`);
    let cantidad = parseInt(cantidadInput.value);

    if (cantidad > 1) {
        cantidad--;
        cantidadInput.value = cantidad;
        producto.cantidad = cantidad;
        localStorage.setItem('carrito', JSON.stringify(carrito));
        total(id);

    }
}
