<!DOCTYPE html> 
<html>
<head> 
    <link href="styles/style.css" rel="stylesheet" type="text/css">
    <link href="styles/style2.css" rel="stylesheet" type="text/css">
    <script src="scripts/producto.js"></script>
    <meta charset="UTF-8" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php"    ?>
<!-- general commit -->

    <div id="back" onclick="history.back()"> 
        <img src="img/angle-left.png"> <p>[Pagina anterior]</p>
    </div>

    <div id=container>    
        <div id="producto">
            <img src="img/<?=$prd["imagen"]?>">
        </div>

        <div id="info">
            <h2><?=$prd["nombre"]?></h2>
            <hr style="width:100%;"> </hr>
            <br>
            <p><?=$prd["descripcion"]?></p>

            <div id="table">
                <table>
                <tr>
                    <th> CATEGORIA </th>
                    <td><?=$prd["categoria"]?></td> 
                </tr>
                <tr>
                    <th> CATEGORIA   </th>
                    <td><?=$prd["subcategoria"]?> </td>
                </tr>
                </table> 
            </div>
        </div>

        <div id="compra">
            <h1> Precio: <span id="precio"> UYU <?=$prd["precio"]?> </span> </h1>
            <br>
            
            <div id="quitaragregar">
                  Cantidad  <button onclick="quitar()">-</button>
                <input type="number" id="cantidad" value="1" min="1" max="99" readonly>
                <button onclick="agregar()">+</button>    
            </div>

            <div id="botones">
                <button> Comprar producto ya</button>
                <button id = "añadir"> Añadir a carrito </button>
            </div>
       
        </div>
  
    </div>
<script>

    function agregar() {

let cantidad = document.getElementById('cantidad');
if (cantidad.value < cantidad.max) {
    cantidad.value = parseInt(cantidad.value) + 1;
}

}

function quitar() {

let cantidad = document.getElementById('cantidad');
if (cantidad.value > cantidad.min) {
    cantidad.value = parseInt(cantidad.value) - 1;
    alert (cantidad);
}
}

</script>
<script>



var producto = <?php echo json_encode($prd); ?>;



document.getElementById('añadir').addEventListener('click', function() {
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            carrito.push(producto);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            alert('Producto añadido al carrito');

        });


    </script>
    <?php include  "segments/footer.php" ?>
</body>
</html>