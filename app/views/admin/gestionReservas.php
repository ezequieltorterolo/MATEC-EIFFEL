<!DOCTYPE html>
<html>

<head>
  <link href="../styles/style8.css" rel="stylesheet" type="text/css">
  <script src="../scripts/reservas.js"></script>
  <meta charset="UTF-8" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Eiffel Importaciones - Gestión de Reservas</title>
</head>

<body>
  <?php include "segments/header.php" ?>
  <div id="title">
    <h1>Gestión de Reservas</h1>
  </div>
  <br>
  <br>

  <div id="botones">
    <form method="POST" action="/admin/gestionReservas"> <!-- Formulario envuelve toda la tabla -->
      <button type="submit">Guardar cambios</button>
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
              <table class="detalles-contenido">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($resprd as $prd): ?>
                    <?php if($prd["reserva_id"] == $res["id"]): ?>
                      <?php foreach ($producto as $prod): ?>
                        <?php if($prod["id"] == $prd["producto_id"]): ?>
                          <tr>
                            <td><img src="../img/<?= $prod['imagen']?>" alt="Imagen del producto"><?= $prod["nombre"] ?></td>
                            <td><?= $prd["cantidad"] ?></td>
                            <td><?= number_format($prd["precio"], 2) ?></td>
                            <td><?= number_format($prd["cantidad"] * $prd["precio"], 2) ?></td>
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
