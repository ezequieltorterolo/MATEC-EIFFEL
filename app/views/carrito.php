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

                id = producto.id;
                // Crear una fila para cada producto
                let productRow = document.createElement('tr');
                productRow.innerHTML = `
                    <td style="width:30%;">
                        <img src="img/${producto.imagen}">
                        <a href =/producto?id=${producto.id} <p>${producto.nombre}</p> </a>
                        <span id="code"> código de producto</span>
                    </td>
                    <td><button onclick="quitar(${producto.id})">-</button>
                  <input type="number" id="cantidad" value="${producto.cantidad}" min="1" max="99" readonly>
                <button onclick="agregar(${producto.id})">+</button> </td>
                    <td id="total">${producto.total}</td>
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
<script>
    
    
    function agregar(id){
      
        
        
    let cantidadInput = document.getElementById('cantidad');
    let cantidad = parseInt(cantidadInput.value);
    // Aumentar la cantidad solo si es menor que el máximo
    if (cantidad < parseInt(cantidadInput.max)) {
        cantidadInput.value = cantidad + 1; // Actualizar el valor del input
        total(id);
    }
}

function quitar(id) {

    let cantidadInput = document.getElementById('cantidad');
    let cantidad = parseInt(cantidadInput.value);

    // Disminuir la cantidad solo si es mayor que el mínimo
    if (cantidad > parseInt(cantidadInput.min)) {
        cantidadInput.value = cantidad - 1; // Actualizar el valor del input
    
        total(id);
    }
}

 </script>  
<script>
        function total(id){
         
            var cantidad = document.getElementById('cantidad').value;
            
            cantidad = parseInt(cantidad, 10);
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            
            let producto = carrito.find(producto => producto.id === id);
            
            var precioCaja =  producto.precioCaja;
            var cantidadCaja = producto.cantidadCaja ;
            var precioUnidad= producto.precio ;
            var stock= producto.stock ;
        
            alert(stock);
          
           
            if(cantidad < cantidadCaja){
                
    
               alert(stock);
                var total =  cantidad * precioUnidad;

                  document.getElementById('total').innerText=   total;
                  
                  var nuevoTotal = total - precioUnidad;
     } 



     if(cantidad > (cantidadCaja - 1) ){
                 
                 var total =  cantidad * precioCaja;
             
                 document.getElementById('total').innerText=  total;
               
                 
                 var nuevoTotal = total - precioCaja;

         }

         if(cantidad == (stock + 1)){ 
                     alert("el stock no es suficiente");
                     let cantidadElejida = document.getElementById('cantidad');
                     cantidadElejida.value = parseInt(cantidadElejida.value) - 1;
     
                   
                   
                  
                  
                     document.getElementById('total').innerText=  nuevoTotal;
                                        
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