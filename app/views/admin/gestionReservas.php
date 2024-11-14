<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../styles/styles_general.css" rel="stylesheet" type="text/css">
  <link href="../styles/style8.css" rel="stylesheet" type="text/css">
  <link href="../styles/popup.css" rel="stylesheet" type="text/css">
  <script src="../scriptÑs/reservas.js"></script>
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
    <form id="formulario" method="POST" action="/admin/gestionReservas">
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <button id="#editar" type="button" class="btn btn-primary" onclick="activarEdicion()">Activar Edicion</button>
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
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservas as $index => $res): ?>
              <tr>
                <input type="hidden" name="id[]" value="<?= $res["id"] ?>">
                <td>
                  <select name="estado[]" id="editable" disabled>
                    <option value="0" <?php if ($res["estado"] == 0): ?>selected <?php endif ?>>En proceso</option>
                    <option value="1" <?php if ($res["estado"] == 1): ?>selected <?php endif ?>>Finalizado</option>
                    <option value="2" <?php if ($res["estado"] == 2): ?>selected <?php endif ?>>Cancelado</option>
                  </select>
                </td>
                <?php foreach ($usuario as $user): ?>
                  <?php if ($user["id"] == $res["usuario_id"]): ?><td><?= $user["nombre"] ?><?php endif; ?></td>
                  <?php endforeach; ?>
                  <td><input id="editable" type="text" name="direccion[]" value="<?= $res["entrega_direccion"] ?>" disabled></td>
                  <td><input id="editable" type="text" name="fecha[]" value="<?= $res['entrega_fechahora'] ?>" disabled></td>
                  <td><input id="editable" type="text" name="aclaraciones[]" value="<?= $res["aclaraciones"] ?>" disabled></td>
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
                                      <button id="editable" type="button" onclick="actualizarCantidad(<?= $prd['id'] ?>,'quitar')" disabled>-</button>
                                      <input id="editable" type="number" id="cantidad-<?= $prd["id"] ?>" name="cantidad[]" value="<?= $resprd['cantidad'] ?>" min="1" max="<?php $prd['stock'] ?>" disabled>
                                      <button id="editable" type="button" onclick="actualizarCantidad(<?= $prd['id'] ?>,'agregar')" disabled>+</button>
                                    </div>
                                  </td>
                                  <td class="precio"><?= number_format($prd["precio"], 2) ?></td>
                                  <td class="subtotal"><?= number_format($resprd["cantidad"] * $prd["precio"], 2) ?></td>
                                  <td><img onclick="eliminarProducto(<?= $resprd['id'] ?>)" src="../img/basura.svg"></td>
                                </tr>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    <!-- Popup modal -->
                    <button type="button" id="boton" class="btn btn-secondary" onclick="openPopup(<?= $res['id'] ?>)">Añadir Producto</button>
                    <div class="popup-overlay" id="popup-<?= $res['id'] ?>" style="display:none;">
                      <form method="POST" action="/admin/agregarProducto">
                        <div class="popup-content">
                          <h4>Seleccione el Producto y la cantidad deseada</h4><br>
                          <input type="hidden" name="reservaId" value="<?= $res['id'] ?>">
                          <select name="prdSeleccionado">
                            <?php foreach ($producto as $prod): ?>
                              <option value="<?= $prod['id'] ?>"><?= $prod["nombre"] ?></option>
                            <?php endforeach ?>
                          </select><br><br>
                          <input type="number" placeholder="cantidad" name="cantidadPrd"><br><br>
                          <button type="button" class="btn btn-secondary" onclick="agregarProducto()">Añadir Producto</button>
                          <button type="button" class="btn btn-secondary" onclick="closePopup(<?= $res['id'] ?>)">Cancelar</button>
                        </div>
                      </form>
                    </div>
                  </div>
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

    function openPopup(id) {
      document.getElementById("popup-" + id).style.display = "flex";
    }

    function closePopup(id) {
      document.getElementById("popup-" + id).style.display = "none";
    }

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
      document.querySelectorAll("#editable").forEach(element => {
        if (element.disabled == true) {
          $("#editar").text("Activar Edicion");
          element.disabled = false;
        } else {
          $("#editar").text("Desactivar Edicion");
          element.disabled = true;
        }
      });
    }

    function agregarProducto() {
      document.getElementById("formulario").action = "/admin/agregarProducto";
      document.getElementById("formulario").submit();
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