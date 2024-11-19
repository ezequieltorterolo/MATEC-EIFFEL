<!DOCTYPE html> 
<html>
<head> 
  

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/home.js"></script>
    <meta charset="UTF-8" />
    <link href="styles/styles_general.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <link href="styles/style2.css" rel="stylesheet" type="text/css">
     <link href="styles/alertpopup.css" rel="stylesheet" type="text/css">
     <link rel="icon"  href="../img/logito.ico">
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php"    ?>

 
   
   
    <div id="back" onclick="history.back()"> 
     <p><img src="img/angle-left.png" alt="Volver"> 
   [Página anterior]</p>
</div> 

<div class="container mb-5">    
    <div class="row flex-column flex-md-row container">
        <div id="tituloalter">
            <h2><?=$prd["nombre"]?></h2>
        </div>
        
        <div id="producto" class="col-md-4 col-sm-12 mx-auto order-md-1 order-2 container">
            <img src="img/<?=$prd["imagen"]?>" class="img-fluid" alt="<?=$prd["nombre"]?>">
        </div>

        <div id="info" class="col-md-4 col-sm-12 order-md-2 order-3 container">
            <div id="titulodesca">
                <h2 ><?=$prd["nombre"]?></h2>
                <hr style="width:100%;">
            </div>

            <div class="mt-3 mb-3 w-100">
                <p><?=$prd["descripcion"]?></p>
            </div>

            <div id="table">
                <table class="table">
                    <tr>
                        <th>CANTIDAD POR CAJA</th>
                        <td><?=$prd["cantidadCaja"]?></td> 
                    </tr>
                    <tr>
                        <th>PRECIO CAJA</th>
                        <td><?=$prd["precioCaja"]?></td> 
                    </tr>
                    <tr>
                        <th>CATEGORÍA</th>
                        <td><?= $cat["nombreCategoria"]?></td> 
                    </tr>
                    <tr>
                        <th>SUBCATEGORÍA</th>
                        <td><?=$prd["subcategoria"]?></td>
                    </tr>
                </table> 
            </div>
        </div>

        <div id="compra" class="col-md-4 col-sm-12 text-left order-md-3 order-2 container text-align-left">
            <div id="precios">
                <div class="row">
                <p>Stock: <?=$prd["stock"]?></p>
                <h1>Precio: <span id="precio">$UYU <?=$prd["precio"]?></span></h1>
                <br>
                <h3 id="total">TOTAL: $<?=$prd["precio"]?></h3>  
            </div>  </div> 
               
            <div class="row">
            <div id="quitaragregar">
                Cantidad  
                <button onclick="quitar()">-</button>
                <input type="number" id="cantidad" value="1" min="1" max="99" readonly>
                <button onclick="agregar()">+</button>    
            </div> </div>

<div class="row">
            <div id="botones1">
                <button id="añadir" class="btn btn-primary">Añadir a carrito</button>
            </div> </div>
        </div>
    </div>
</div>
  
   

<script>

var producto = <?php echo json_encode($prd); ?>;



    function agregar() {

         let cantidad = document.getElementById('cantidad');
         if (cantidad.value < cantidad.max) {
         cantidad.value = parseInt(cantidad.value) + 1;
        total();
    }

}

   function quitar() {

       let cantidad = document.getElementById('cantidad');
       if (cantidad.value > cantidad.min) {
       cantidad.value = parseInt(cantidad.value) - 1;
       total();

            } 


          
    }


    function total() {
                var precioCaja =  "<?=$prd["precioCaja"]?> ";
                var cantidadCaja = "<?=$prd["cantidadCaja"]?>" ;
                var precioUnidad= "<?=$prd["precio"]?>" ;
                var stock= <?=$prd["stock"]?> ;
                var cantidad = document.getElementById('cantidad').value;
                cantidad = parseInt(cantidad, 10);

                
                if(cantidad < cantidadCaja){
    
                 
               var total =  cantidad * precioUnidad;
               total= total.toFixed(2);
    
               document.getElementById('total').innerText=  "TOTAL $"+ total;
               producto.total = total;
               var nuevoTotal = total - precioUnidad;
                } 


              if(cantidad > (cantidadCaja - 1) ){
                 
                    let total=cantidad * precioCaja;
                    total= total.toFixed(2);
                
                    document.getElementById('total').innerText= "TOTAL $"+ total;
                  
                    producto.total = total;
                    var nuevoTotal = total - precioCaja;

            }

            if(cantidad == (stock + 1)){ 
              
                        let cantidadElejida = document.getElementById('cantidad');
                        cantidadElejida.value = parseInt(cantidadElejida.value) - 1;
                        cantidadElejida= cantidadElejida.toFixed(2);
        
                        mostrarPopup("Cantidad maxima", false);
                      
                     
                     
                        document.getElementById('total').innerText= "TOTAL $"+ nuevoTotal;
                        producto.total = nuevoTotal;                    
                    }


        }





  

    

    
       document.getElementById('añadir').addEventListener('click', function() {
          let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        var idd= producto.id;

         if(carrito.find(producto => producto.id == idd)){
            mostrarPopup("ya tienes este producto en carrito", false);

         } else {

          let cantidad = producto.cantidad;
          

           var cantidadElejida = document.getElementById("cantidad").value;
           producto.cantidad = cantidadElejida;
    
            // mostrar la cantidad de productos en el carrito del nav




    
           /// 
           
            carrito.push(producto);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            mostrarPopup("Producto agregado al carrito", true);

             // mostrar la cantidad de productos en el carrito del nav

             let cantidadCarrito = carrito.length;   
 
           // Cambiar el contenido de un div
             document.getElementById("badge-carrito").innerHTML = cantidadCarrito;
             document.getElementById("carr-cantidad").innerHTML = cantidadCarrito;
// Guardar el cambio en localStorage
             localStorage.setItem("contenidoDiv", cantidadCarrito);

// Al recargar la página, restaurar el contenido
window.addEventListener("load", function() {
    const contenidoGuardado = localStorage.getItem("contenidoDiv");
    if (contenidoGuardado) {
        document.getElementById("miDiv").innerHTML = contenidoGuardado;
    }
});
    
/// 
         }

       } );

        
      </script>

<script src="scripts/alertpopup.js"></script>
    <?php include  "segments/footer.php" ?>
</body>
</html>