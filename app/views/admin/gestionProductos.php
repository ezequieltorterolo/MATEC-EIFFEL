<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../styles/style6.css" rel="stylesheet" type="text/css">
  <script src="../scripts/producto.js"></script>
  <meta charset="UTF-8" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Eiffel Importaciones</title>
</head>

<body>
  <?php include  "segments/header.php" ?>
  <div id="titulo" class="container-fluid">
    <div class="row">
    
<div class="col-12 text-left mt-3">
   <h2> Gestión de Productos </h2> 
</div>
<hr>
  <div class="col-4 mt-3 mb-3" id="atras">
   <p> <img src="../img/angle-left.png"> Volver atras <p>
</div>
</div>
</div>
  <div id="botones">
    <div class="row">
  <div class="col-1"> <button onclick="añadirProducto()" class="btn btn-primary">Añadir Producto</button>
    <form method="POST" action="/admin/gestionProductos"> </div>
<div class="col-1">   <button type="submit" class="btn btn-primary">Guardar Todo</button> </div>
</div>
  </div>
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

      <?php foreach ($data as $index => $prd): ?>
        <tr>
          <input type="hidden" name="id[]" value="<?= $prd['id'] ?>">

          <td>
            <a href="/admin/productoAdmin?id=<?= $prd['id'] ?>">
              <img src="../img/<?= $prd['imagen'] ?>">
            </a>
            <?= $prd['nombre'] ?>
          </td>

          <td>
            <input type="number" name="precio[]" value="<?= $prd['precio'] ?>" min="1">
          </td>

          <td>
            <input type="number" name="precioCaja[]" value="<?= $prd['precioCaja'] ?>" min="1">
          </td>

          <td>
            <div id="quitaragregar">
              <button type="button" onclick="actualizarStock(<?= $index ?>, 'quitar')">-</button>
              <input type="number" name="stock[]" id="stock-<?= $index ?>" value="<?= $prd['stock'] ?>" min="0" max="99" readonly>
              <button type="button" onclick="actualizarStock(<?= $index ?>, 'agregar')">+</button>
            </div>
          </td>

          <td>
            <input type="checkbox" name="oferta[<?= $index ?>]" value="1" <?= $prd['oferta'] ? 'checked' : '' ?>>
          </td>

          <td>
            <img src="../img/basura.svg" id="basura" onclick="eliminar(<?= $prd['id'] ?>)">
            <button type="button" onclick="editar(<?= $prd['id'] ?>)">Editar</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    </form>

  </div>


  <script>
    window.addEventListener("load", (event) => {
      <?php if (!empty($msg)): ?>
        let mensaje = <?= json_encode($msg) ?>;
        alert(mensaje);
      <?php endif; ?>
    });


    function añadirProducto() {
      document.location.href = "/admin/aniadirProducto";
    }

    function editar(id) {
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

    function actualizarStock(id, accion) {
      const stockInput = document.getElementById(`stock-${id}`); // Selección específica
      let stock = parseInt(stockInput.value);

      // Incrementar o decrementar el stock
      if (accion === 'agregar' && stock < 99) stock++;
      if (accion === 'quitar' && stock > 0) stock--;

      // Actualizar el valor del input
      stockInput.value = stock;

      // Llamar a la función para enviar los cambios a la base de datos
      actualizarProducto(id, 'stock', stock);
    }
  </script>



  <a href="/admin">ADMIN HOME</a>