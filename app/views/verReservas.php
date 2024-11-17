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
      <div id="tabla-prod">
        <table>
          <thead>
            <tr>
              <th>Estado</th>
              <th>Calle</th>
              <th>Fecha</th>
              <th>Aclaraciones</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservas as $index => $res): ?>
              <tr>
              <td id="estado" data-estado="<?= $res['estado'] ?>"></td>
                <td><?= $res["entrega_direccion"] ?></td>
                <td><?= $res['entrega_fechahora'] ?></td>
                <td><?= $res["aclaraciones"] ?></td>
                <td>
                  <button class="boton" type="button" onclick="mostrarProductos(this)">▼</button>
                  <button type="button" class="btn btn-primary" onclick="cancelarReserva(<?= $res['id'] ?>)">Cancelar</button>
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
                              <?php if ($prd["id"] == $resprd["producto_id"]):?>
                                <tr>
                                  <td><img src="../img/<?= $prd['imagen'] ?>" alt="Imagen del producto" id="imagen-pro"></td>
                                  <td><?= $prd["nombre"] ?></td>
                                  <td><?= $resprd['cantidad']?></td>
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
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

  <script>
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
  // Función que establece el estado basado en la variable PHP $estado
  function establecerEstado() {
    // Selecciona todos los elementos con id "estado"
    const estadoCells = document.querySelectorAll("td#estado");

    estadoCells.forEach(cell => {
      // Obtén el valor del atributo data-estado
      const estado = cell.getAttribute("data-estado");

      // Define el texto correspondiente al estado
      let textoEstado = "";
      switch (estado) {
        case "0":
          textoEstado = "En proceso";
          break;
        case "1":
          textoEstado = "Finalizado";
          break;
        case "2":
          textoEstado = "Cancelado";
          break;
        default:
          textoEstado = "Desconocido";
          break;
      }
      cell.textContent = textoEstado;
    });
  }
  document.addEventListener("DOMContentLoaded", establecerEstado);

    function cancelarReserva(id) {
      let confirmacion = confirm("Estas seguro de querer cancelar la reserva?");
      if (confirmacion) {
        document.location.href = "/cancelarReserva?resid=" + id;
      }
    }
  </script>
</body>

</html>