<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <link href="../styles/styles_general.css" rel="stylesheet" type="text/css">
  <link href="../styles/style8.css" rel="stylesheet" type="text/css">
 
  <script src="../scripts/reservas.js"></script>
  <meta charset="UTF-8" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Eiffel Importaciones - Gestión de Reservas</title>
</head>

<body>
  <?php include "segments/header.php" ?>
  <div id="titulo" class="container-fluid">
    <div class="row">
    
<div class="col-12 text-left mt-3">
   <h2> Gestión de Reservas </h2> 
</div>
<hr>
  <div class="col-4 mt-3 mb-3" id="atras"  onclick="history.back()">
   <p> <img src="../img/angle-left.png"> Volver atras <p>
</div>
</div>
</div>
  

  <div id="botones" class="container">
    <form method="POST" action="/admin/gestionReservas"> <!-- Formulario envuelve toda la tabla -->
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="submit" class="btn btn-primary">Guardar cambios</button> 
<button type="submit" class="btn btn-primary">Editar</button> 

  </div>

  <div id="tabla-prod">
    <table>
      <thead>
        <tr>
          <th>Estado</th>
          <th>Calle</th>
          <th>Fecha</th>
          <th>Aclaraciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservas as $res): ?>
          <tr>
            <input type="hidden" name="id[]" value="<?= $res["id"] ?>">
            <td>
              <select name="estado[]">
                <option value="0" <?php if($res["estado"] == 0):?>selected <?php endif?>>En proceso</option>
                <option value="1" <?php if($res["estado"] == 1):?>selected <?php endif?>>Finalizado</option>
                <option value="2" <?php if($res["estado"] == 2):?>selected <?php endif?>>Cancelado</option>
              </select>
            </td>
            <td><?= $res["entrega_direccion"] ?></td>
            <td><?= $res["entrega_fechahora"] ?></td>
            <td><?= $res["aclaraciones"] ?></td>
            <td>
              <button class="boton" type="button" onclick="mostrarProductos(this)">▼</button>
            </td>
          </tr>

          <tr class="detalles-fila" style="display: none;">
            <td colspan="6">
              <div id="dropdown">
              <table class="detalles-contenido">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th> Accion </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($resprd as $prd): ?>
                    <?php if($prd["reserva_id"] == $res["id"]): ?>
                      <?php foreach ($producto as $prod): ?>
                        <?php if($prod["id"] == $prd["producto_id"]): ?>
                          <tr>
                            <td><img src="../img/<?= $prod['imagen']?>" alt="Imagen del producto" id="imagen-pro" ><?= $prod["nombre"] ?></td>
                            <td><?= $prd["cantidad"] ?></td>
                            <td><?= number_format($prd["precio"], 2) ?></td>
                            <td><?= number_format($prd["cantidad"] * $prd["precio"], 2) ?></td>
                     <td> <img src="../img/basura.svg"> </td>
                          </tr>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
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

    function mostrarProductos(boton) {
      const detallesFila = boton.closest("tr").nextElementSibling;
      if (detallesFila.style.display === "none") {
        detallesFila.style.display = "table-row";
        boton.textContent = "▲";
      } else {
        detallesFila.style.display = "none";
        boton.textContent = "▼";
      }
    }
  </script>
</body>

</html>
