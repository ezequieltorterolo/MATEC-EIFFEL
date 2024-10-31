console.log("carrito.js cargado correctamente");

let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
let carritoContainer = document.querySelector('#tabla-prod table');

function carrito_confirmar() {
    


}



function mostrarCarrito() {
    carritoContainer.innerHTML = `
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Stock</th>
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
    }
}

function agregarFila(producto, index) {
    let prdinfo = producto.info;
    let productRow = document.createElement('tr');
    let stockIndicator = "";

    if (producto.cantidad > prdinfo.stock) {
        producto.cantidad = prdinfo.stock;
        stockIndicator = `<span style="color:orange;">Stock limitado: ${prdinfo.stock}</span>`;
    } else if (prdinfo.stock <= 5) {
        stockIndicator = `<span style="color:red;">Stock bajo: ${prdinfo.stock}</span>`;
    } else {
        stockIndicator = `${prdinfo.stock}`;
    }

    productRow.innerHTML = `s
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
        <td id="total_${producto.id}">${calcularTotal(producto).toFixed(2)}</td>
        <td>${stockIndicator}</td>
        <td><img onclick="borrarProducto(${index})" src="img/basura.svg" id="basura" style="cursor: pointer;"></td>
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

