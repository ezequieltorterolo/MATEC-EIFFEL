<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
      <div class="col-4 mt-3 mb-3" id="atras" onclick="history.back()">
        <p><img src="../img/angle-left.png"> Volver atras</p>
      </div>
    </div>
  </div>

  <div id="botones" class="container">
    <form method="POST" action="/admin/gestionReservas">
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <button type="button" class="btn btn-primary" onclick="activarEdicion()">Editar</button>
      </div>

      <div id="tabla-prod">
        <table>
          <thead>
            <tr>
              <th>Estado</th>
              <th>Usuario</th>
              <th>Calle</th>
              <th>Fecha</th>
              <th>Aclaraciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservas as $index => $res): ?>
              <tr>
                <input type="hidden" name="id[]" value="<?= $res["id"] ?>">
                <td>
                  <select name="estado[]" disabled>
                    <option value="0" <?php if ($res["estado"] == 0): ?>selected <?php endif ?>>En proceso</option>
                    <option value="1" <?php if ($res["estado"] == 1): ?>selected <?php endif ?>>Finalizado</option>
                    <option value="2" <?php if ($res["estado"] == 2): ?>selected <?php endif ?>>Cancelado</option>
                  </select>
                </td>
                <?php foreach ($usuario as $user): ?> <?php if ($user["id"] == $res["usuario_id"]): ?>
                    <td><?= $user["nombre"] ?> <?php endif; ?></td>
                  <?php endforeach; ?>
                  <td><input type="text" name="direccion[]" value="<?= $res["entrega_direccion"] ?>" disabled></td>
                  <td><input type="datetime-local" name="fecha[]" value="<?= $res['entrega_fechahora'] ?>" disabled></td>
                  <td><input type="text" name="aclaraciones[]" value="<?= $res["aclaraciones"] ?>" disabled></td>
                  <td>
                    <button class="boton" type="button" onclick="mostrarProductos(this)">▼</button>
                    <img onclick="eliminarReserva(<?= $res['id'] ?>)" src="../img/basura.svg">
                  </td>
              </tr>

              <tr class="detalles-fila" style="display: none;">
                <td colspan="6">
                  <div id="dropdown">
                    <table class="detalles-contenido">
                      <thead>
                        <tr>
                          <th>Producto</th>
                          <th>Nombre</th>
                          <th>Cantidad</th>
                          <th>Precio</th>
                          <th>Subtotal</th>
                          <th>Accion</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($reservaproducto as $index2 => $resprd): ?>
                          <?php if ($resprd["reserva_id"] == $res["id"]): ?>
                            <?php foreach ($producto as $prd): ?>
                              <?php if ($prd["id"] == $resprd["producto_id"]): ?>
                                <tr>
                                  <input type="hidden" name="idPrd[]" value="<?= $resprd['id'] ?>">
                                  <td><img src="../img/<?= $prd['imagen'] ?>" alt="Imagen del producto" id="imagen-pro"></td>
                                  <td><?= $prd["nombre"] ?></td>
                                  <td>
                                    <div id="quitaragregar">
                                      <button type="button" onclick="actualizarCantidad(<?= $prd['id'] ?>,'quitar')" disabled>-</button>
                                      <input type="number" id="cantidad-<?= $prd["id"] ?>" name="cantidad[]" value="<?= $resprd['cantidad'] ?>" min="1" max="<?php $prd['stock'] ?>" disabled>
                                      <button type="button" onclick="actualizarCantidad(<?= $prd['id'] ?>,'agregar')" disabled>+</button>
                                    </div>
                                  </td>
                                  <td class="precio"><?= number_format($prd["precio"], 2) ?></td>
                                  <td class="subtotal"><?= number_format($resprd["cantidad"] * $prd["precio"], 2) ?></td>
                                  <td><img onclick="eliminarProducto(<?= $resprd['id'] ?>)" src="../img/basura.svg"></td>
                                </tr>
                              <?php endif; ?>
                            <?php endforeach; ?>
                            <tr>
                            </tr>
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
    $(document).ready(function() {
      function actualizarSubtotal($row) {
        const precio = parseFloat($row.find(".precio").text());
        const cantidad = parseInt($row.find("input[type='number']").val());
        const subtotal = (cantidad * precio).toFixed(2);
        $row.find(".subtotal").text(subtotal);
      }
      $(document).on("change", "input[type='number']", function() {
        const row = $(this).closest("tr");
        actualizarSubtotal(row);
      });

      function actualizarCantidad(id, accion) {
        const $cantidadInput = $(`#cantidad-${id}`);
        let cantidad = parseInt($cantidadInput.val());
        if (accion === 'agregar') cantidad++;
        if (accion === 'quitar') cantidad--;
        $cantidadInput.val(cantidad);
        const row = $cantidadInput.closest("tr");
        actualizarSubtotal(row);
      }
      window.actualizarCantidad = actualizarCantidad;
    });

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

    function activarEdicion() {
      document.querySelectorAll("input,button, select").forEach(element => {
        element.disabled = false;
      });
    }

    function agregarProducto(id) {
      document.location.href = "/admin/agregarProducto?resid=" + id;
    }

    function eliminarProducto(id) {
      let confirmacion = confirm("Estas seguro de eliminar el producto?");
      if (confirmacion) {
        document.location.href = "/admin/eliminarProducto?prdid=" + id;
      }
    }

    function eliminarReserva(id) {
      let confirmacion = confirm("Estas seguro de eliminar la reserva?");
      if (confirmacion) {
        document.location.href = "/admin/eliminarReserva?resid=" + id;
      }
    }
  </script>
</body>

</html>