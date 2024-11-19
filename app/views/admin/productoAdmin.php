<!DOCTYPE html> 
<html>
<head> 
    <link href="../styles/style.css" rel="stylesheet" type="text/css">
    <link href="../styles/style2.css" rel="stylesheet" type="text/css">
    <script src="../scripts/producto.js"></script>
    <meta charset="UTF-8" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon"  href="../img/logito.ico">
    <script src="../scripts/alertpopup.js"></script> <!-- Incluye el script aquí -->
    <title>Eiffel Importaciones</title>
</head>
<body>
<?php include  "segments/header.php" ?>

  

    <div id="back" onclick="history.back()"> 
        <img src="../img/angle-left.png"> <p>[Pagina anterior]</p>
    </div>

    <div id=container>    
        <div id="producto">
            <img src="../img/<?=$prd["imagen"]?>">
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
            

            <div id="botones">
                <button onclick="editar(<?=$prd['id']?>)"> Editar </button>
                <button onclick="confirmar(<?=$prd['id']?>)"> Eliminar </button>
            </div>
       
        </div>
  
    </div>
    <script>
           window.addEventListener("load", (event) => {
        <?php if (!empty($msg)): ?>
            let mensaje = <?= json_encode($msg) ?>;
            mostrarPopup(mensaje, false); // Cambia alert por mostrarPopup
        <?php endif; ?>
    });

        function confirmar(id){
          let confirmacion = confirm("Estas seguro de eliminar el producto?");
          if(confirmacion){
            document.location.href="/admin/eliminar?prdid="+id;
        }
    }
        function editar(id){
            document.location.href="/admin/modificarProducto?prdid="+id;
        }

    </script>