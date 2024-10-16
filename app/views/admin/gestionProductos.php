<!DOCTYPE html>
<html>

<head>
  <link href="../styles/style6.css" rel="stylesheet" type="text/css">
  <script src="../scripts/producto.js"></script>
  <meta charset="UTF-8" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Eiffel Importaciones</title>
</head>

<body>
  <?php include  "segments/header.php" ?>
  <div id="title">
    <h1>Gestionar productos</h1>
  </div>
  <br>
  <br>
  
  <div id="botones">
          <div><button onclick="añadirProducto()">Añadir Producto</button></div>
  </div>
  <form method="POST" action="/admin/gestionProductos">
  <div id="tabla-prod">



      <table>
        
        <tr>
          <th>Producto</th>
          <th>Precio x Unidad</th>
          <th>Precio x Caja</th>
          <th>Stock</th>
          <th>Oferta</th>
          <th>Opciones</th>
        </tr>
        
        <?php foreach ($data as $prd): ?>
        <tr>
          <td style="width:30%;">
            <a href=/admin/productoAdmin?id=<?= $prd["id"] ?> name ="prdId"><img src=../img/<?= $prd["imagen"] ?>></a>
            <?= $prd["nombre"] ?></p> <span id="code"> codigo de producto</span>
          <td><input type="number" id="precio" name ="precio" value=<?= $prd["precio"] ?> min="1"></td>
          <td><input type="number" id="precioCaja" name ="precioCaja" value=<?= $prd["precioCaja"] ?> min="1"></td>
          <td>
            <div id="quitaragregar">
              <button onclick="quitar($prd['stock'])">-</button>
              <input type="number" id="stock" value=<?= $prd["stock"] ?> min="0" max="99" readonly>
              <button onclick="agregar()">+</button>
            </div>
          </td>
          <td><input id="ofertas" type="checkbox" <?= $prd['oferta'] == 1 ? 'checked' : '' ?>></td>
          <td><button type="button" onclick="editar(<?= $prd['id'] ?>)">editar</button>
           <img src="../img/basura.svg" id="basura" onclick="eliminar(<?= $prd['id'] ?>)"> </img> 
        </td>
        <?php endforeach ?>
        </form>
        </tr>
      </table>
  </div>

  <script>
    function añadirProducto(){
      document.location.href = "/admin/aniadirProducto";
    }

    function editar(id){
      document.location.href = "/admin/modificarProducto?prdid="+id;
    }

    function eliminar(id) {
      let confirmacion = confirm("Estas seguro de eliminar el producto?");
      if (confirmacion) {
        document.location.href = "/admin/eliminar?prdid="+id;
      }
    }
    function agregar(cantidad) {
      if (cantidad.value < cantidad.max) {
        cantidad.value = parseInt(cantidad.value) + 1;
      }

    }

    function quitar(cantidad) {
      if (cantidad.value > cantidad.min) {
        cantidad.value = parseInt(cantidad.value) - 1;
      }



    }
  </script>



  <a href="/admin">ADMIN HOME</a>