<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link href="../styles/styles_general.css" rel="stylesheet" type="text/css">
  <link href="../styles/popup.css" rel="stylesheet" type="text/css">
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
    <div class="btn-group" role="group" aria-label="Basic example">
      <form id="formEst" method="GET" action="/admin/gestionReservas">
        <select id="filtroEst" name="estado2">
          <option value="-1">Todas las reservas</option>
          <option value="0">En proceso</option>
          <option value="1">Finalizado</option>
          <option value="2">Cancelado</option>
        </select>
      </form>
    </div>
    <form method="POST" id="formulario" action="/admin/gestionReservas">
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" id="edicion" class="btn btn-primary" onclick="activarEdicion()">Activar Edicion</button>
        <button type="submit" class="btn btn-success">Guardar cambios</button>

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
              <th>Accion</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservas as $index => $res): ?>
              <tr>
                <input type="hidden" name="id[]" id="editable" value="<?= $res["id"] ?>">
                <td>
                  <select name="estado[]" id="editable" disabled>
                    <option value="0" <?php if ($res["estado"] == 0): ?>selected <?php endif ?>>En proceso</option>
                    <option value="1" <?php if ($res["estado"] == 1): ?>selected <?php endif ?>>Finalizado</option>
                    <option value="2" <?php if ($res["estado"] == 2): ?>selected <?php endif ?>>Cancelado</option>
                  </select>
                </td>
                <?php foreach ($usuario as $user): ?> <?php if ($user["id"] == $res["usuario_id"]): ?>
                    <td><?= $user["nombre"] ?> <?php endif; ?></td>
                  <?php endforeach; ?>
                  <td><input type="text" name="direccion[]" id="editable" value="<?= $res["entrega_direccion"] ?>" disabled></td>
                  <td><input type="text" name="fecha[]" id="editable" value="<?= $res['entrega_fechahora'] ?>" disabled></td>
                  <td><input type="text" name="aclaraciones[]" id="editable" value="<?= $res["aclaraciones"] ?>" disabled></td>
                  <td>
                    <img id="basura" onclick="eliminarReserva(<?= $res['id'] ?>)" src="../img/basura.svg">
                    <button class="mostrar" type="button" onclick="mostrarProductos(this)">▼</button>
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
                                      <button type="button" id="editable" onclick="actualizarCantidad(<?= $prd['id'] ?>,'quitar')" disabled>-</button>
                                      <input type="number" id="cantidad-<?= $prd["id"] ?>" name="cantidad[]" value="<?= $resprd['cantidad'] ?>" min="1" max="<?php $prd['stock'] ?>" readonly>
                                      <button type="button" id="editable" onclick="actualizarCantidad(<?= $prd['id'] ?>,'agregar',<?php $prd['stock'] ?>)" disabled>+</button>
                                    </div>
                                  </td>
                                  <td class="precio"><?= number_format($prd["precio"], 2) ?></td>
                                  <td class="subtotal"><?= number_format($resprd["cantidad"] * $prd["precio"], 2) ?></td>
                                  <td><img onclick="eliminarProductoReserva(<?= $resprd['id'] ?>)" src="../img/basura.svg"></td>
                                </tr>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    <!-- Popup modal -->
                    <button type="button" id="boton" class="btn btn-primary" onclick="openPopup(<?= $res['id'] ?>)">Añadir Producto</button>
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
                          <button type="button" class="btn btn-primary" onclick="agregarProducto()">Añadir Producto</button>
                          <button type="button" class="btn btn-primary" onclick="closePopup(<?= $res['id'] ?>)">Cancelar</button>
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
      

      function actualizarCantidad(id, accion, max) {
        const $cantidadInput = $(`#cantidad-${id}`);
        let cantidad = parseInt($cantidadInput.val());
        if (accion === 'agregar' && cantidad < max) cantidad++;
        if (accion === 'quitar' && cantidad > 0) cantidad--;
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

    function agregarProducto() {
      document.getElementById("formulario").action = "/admin/agregarProducto";
      document.getElementById("formulario").submit();
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
    const campos = document.querySelectorAll('#editable');
    const editButton = document.getElementById("edicion");

    // Cambiar el estado de los campos y actualizar el texto del botón
    const habilitar = campos[0].disabled; // Asume que todos los campos tienen el mismo estado
    campos.forEach(campo => campo.disabled = !habilitar);
    editButton.textContent = habilitar ? "Desactivar Edición" : "Activar Edición";
}
    function agregarProducto() {
      document.getElementById("formulario").action = "/admin/agregarProducto";
      document.getElementById("formulario").submit();
    }

    function eliminarProductoReserva(id) {
      let confirmacion = confirm("Estas seguro de eliminar el producto?");
      if (confirmacion) {
        document.location.href = "/admin/eliminarProductoReserva?prdid=" + id;
      }
    }

    function eliminarReserva(id) {
      let confirmacion = confirm("Estas seguro de eliminar la reserva?");
      if (confirmacion) {
        document.location.href = "/admin/eliminarReserva?resid=" + id;
      }
    }

    function activarEdicion() {
      document.querySelectorAll("#editable").forEach(element => {
        element.disabled = false;
      });
    }

    function openPopup(id) {
      document.getElementById("popup-" + id).style.display = "flex";
    }

    function closePopup(id) {
      document.getElementById("popup-" + id).style.display = "none";
    }

    const selectFiltroEst = document.getElementById("filtroEst");
    const formEst = document.getElementById("formEst");
    const defaultEstado = localStorage.getItem("defaultEstado2");
    if (defaultEstado !== null) {
      selectFiltroEst.value = defaultEstado;
    }
    selectFiltroEst.addEventListener("change", (event) => {
      localStorage.setItem("defaultEstado2", selectFiltroEst.value);

      formEst.submit();
    });
  </script>
</body>

</html>