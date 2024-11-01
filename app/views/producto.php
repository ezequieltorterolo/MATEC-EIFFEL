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
   
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php"    ?>

 
   
   
    <div id="back" onclick="history.back()"> 
    <img src="img/angle-left.png" alt="Volver"> 
    <p>[Página anterior]</p>
</div> 

<div class="container mb-5">    
    <div class="row flex-column flex-md-row">
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

            <div>
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
                        <td><?=$prd["categoria"]?></td> 
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
            <div id="botones">
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
    
               document.getElementById('total').innerText=  "TOTAL $"+ total;
               producto.total = total;
               var nuevoTotal = total - precioUnidad;
                } 


              if(cantidad > (cantidadCaja - 1) ){
                 
                    var total =  cantidad * precioCaja;
                
                    document.getElementById('total').innerText= "TOTAL $"+ total;
                  
                    producto.total = total;
                    var nuevoTotal = total - precioCaja;

            }

            if(cantidad == (stock + 1)){ 
                        alert("el stock no es suficiente")
                        let cantidadElejida = document.getElementById('cantidad');
                        cantidadElejida.value = parseInt(cantidadElejida.value) - 1;
        
                      
                      
                     
                     
                        document.getElementById('total').innerText= "TOTAL $"+ nuevoTotal;
                        producto.total = nuevoTotal;                    
                    }


        }





  

    

    
       document.getElementById('añadir').addEventListener('click', function() {
          let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        var idd= producto.id;

         if(carrito.find(producto => producto.id == idd)){
            alert('ya tienes este producto en carrito');

         } else {

          let cantidad = producto.cantidad;

           var cantidadElejida = document.getElementById("cantidad").value;
           producto.cantidad = cantidadElejida;

    
           
            carrito.push(producto);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            alert('Producto añadido al carrito');
         }

       } );

        
      </script>


    <?php include  "segments/footer.php" ?>
</body>
</html>