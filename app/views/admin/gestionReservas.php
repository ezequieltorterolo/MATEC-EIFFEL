<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../scripts/alertpopup.js"></script> <!-- Incluye el script aquí -->
  <link href="../styles/styles_general.css" rel="stylesheet" type="text/css">
  <link href="../styles/style8.css" rel="stylesheet" type="text/css">
  <link href="../styles/popup.css" rel="stylesheet" type="text/css">
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
      <div class="col-4 mt-3 mb-3" id="atras">
        <p><img src="../img/angle-left.png"><a href="/admin"> Volver atras </a></p>
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
    <form id="formulario" method="POST"  onsubmit="verificarCamposHabilitados(event)" action="/admin/gestionReservas">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <button id="edicion" type="button" class="btn btn-primary" onclick="activarEdicion()">Activar Edicion</button>
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
                <input type="hidden" name="id[]" value="<?= $res["id"] ?>">
                <td>
                  <select name="estado[]" id="editable" disabled>
                    <option value="0" <?php if ($res["estado"] == 0): ?>selected <?php endif ?>>En proceso</option>
                    <option value="1" <?php if ($res["estado"] == 1): ?>selected <?php endif ?>>Finalizado</option>
                    <option value="2" <?php if ($res["estado"] == 2): ?>selected <?php endif ?>>Cancelado</option>
                  </select>
                </td>
                <?php foreach ($usuario as $user): ?>
                  <?php if ($user["id"] == $res["usuario_id"]):?><td><?= $user["nombre"] ?><?php endif; ?></td>
                  <?php endforeach; ?>
                  <td><input id="editable" type="text" name="direccion[]" value="<?= $res["entrega_direccion"] ?>" disabled></td>
                  <td><input id="editable" type="text" name="fecha[]" value="<?= $res['entrega_fechahora'] ?>" disabled></td>
                  <td><input id="editable" type="text" name="aclaraciones[]" value="<?= !empty($res['aclaraciones']) ? $res['aclaraciones'] : 'N/A' ?>" disabled></td>
                  <td>
                    <button class="boton" type="button" onclick="mostrarProductos(this)">▼</button>
                    <img id="basura" onclick="eliminarReserva(<?= $res['id'] ?>)" src="../img/basura.svg">
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
                                  <td><img id="imagen-pro" src="../img/<?= $prd['imagen'] ?>" alt="Imagen del producto" ></td>
                                  <td><?= $prd["nombre"] ?></td>
                                  <td>
                                    <div id="quitaragregar">
                                      <button id="editable" type="button" onclick="actualizarCantidad(<?= $prd['id'] ?>,'quitar')" disabled>-</button>
                                      <input type="number" id="cantidad-<?= $prd["id"] ?>" name="cantidad[]" value="<?= $resprd['cantidad'] ?>" min="1" max="<?php $prd['stock']?>">
                                      <button id="editable" type="button" onclick="actualizarCantidad(<?= $prd['id'] ?>,'agregar')" disabled>+</button>
                                    </div>
                                  </td>
                                  <td class="precio"><?= number_format($prd["precio"], 2) ?></td>
                                  <td class="subtotal"><?= number_format($resprd["cantidad"] * $prd["precio"], 2) ?></td>
                                  <td><img id="basura" onclick="eliminarProducto(<?= $resprd['id'] ?>)" src="../img/basura.svg"></td>
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
  <br>

  <?php include "segments/footer.php" ?>
  <script>
       window.addEventListener("load", (event) => {
        <?php if (!empty($msg)): ?>
            let mensaje = <?= json_encode($msg) ?>;
            mostrarPopup(mensaje, false); // Cambia alert por mostrarPopup
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
    //filtrar por estado
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

    function verificarCamposHabilitados(event) {
    // Prevenir el envío del formulario
    event.preventDefault();

    // Seleccionar todos los elementos con el atributo "id=editable"
    const camposEditables = document.querySelectorAll('#editable');
    let todosHabilitados = true;

    // Verificar si todos los campos están habilitados
    camposEditables.forEach(campo => {
        if (campo.disabled) {
            todosHabilitados = false;
            campo.disabled = false; // Habilitar el campo
        }
    });

    // Si había campos deshabilitados, detener el envío y alertar al usuario
    if (!todosHabilitados) {
        alert("Algunos campos estaban deshabilitados. Ahora están habilitados. Por favor, revisa los datos y vuelve a enviar.");
        return;
    }

    // Si todos los campos estaban habilitados, proceder con el envío del formulario
    document.getElementById('formulario').submit();
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
        if (accion === 'agregar' && cantidad < 99) cantidad++;
        if (accion === 'quitar' && cantidad > 0) cantidad--;
        $cantidadInput.val(cantidad);
        const row = $cantidadInput.closest("tr");
        actualizarSubtotal(row);
      }
      window.actualizarCantidad = actualizarCantidad;
    });

    function eliminarProducto(id) {
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
  </script>
</body>

</html>