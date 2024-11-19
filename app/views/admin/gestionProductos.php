<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../scripts/alertpopup.js"></script>
  <link href="../styles/styles_general.css" rel="stylesheet" type="text/css">
  <link href="../styles/style6.css" rel="stylesheet" type="text/css">
  <link rel="icon"  href="../img/logito.ico">

  <script src="../scripts/producto.js"></script>
  <meta charset="UTF-8" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Eiffel Importaciones - Gestion de Productos</title>
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
        <p><img src="../img/angle-left.png"><a href="/admin"> Volver atras</a></p>
      </div>
    </div>
  </div>
  <div id="botones" class="container">
    <div class="btn-group" role="group" aria-label="Basic example">
      <form id="formCat" method="GET" action="/admin/gestionProductos">
        <select id="filtroCat" name="categoria">
          <option value="-1">Todos los productos</option>
          <?php foreach ($catego as $cat): ?>
            <option value="<?= $cat["id"] ?>"><?= $cat["nombreCategoria"] ?></option>
          <?php endforeach; ?>
        </select>
      </form>
      <button onclick="añadirProducto()" class="btn btn-primary">Añadir Producto</button>
      <button class="btn btn-primary" onclick="activarEdicion()">Activar Edicion</button>
      <form method="POST"  onsubmit="verificarCamposHabilitados(event)" action="/admin/gestionProductos">
        <button type="submit" class="btn btn-success">Guardar Todo</button>
    </div>
  </div>
  <div id="tabla-prod">
    <table>
      <tr>
        <th>Producto</th>
        <th>Nombre</th>
        <th>Precio x Unidad</th>
        <th>Precio x Caja</th>
        <th>Stock</th>
        <th>Oferta</th>
        <th>Accion</th>
      </tr>

      <?php foreach ($data as $index => $prd): ?>
        <tr>
          <input type="hidden" name="id[]" value="<?= $prd['id'] ?>">

          <td><a href="/admin/productoAdmin?id=<?= $prd['id'] ?>"><img src="../img/<?= $prd['imagen'] ?>"></a></td>
          <td><?= $prd['nombre'] ?></td>
          <td><input id="editable" type="number" name="precio[]" value="<?= $prd['precio'] ?>" min="1" disabled></td>
          <td><input id="editable" type="number" name="precioCaja[]" value="<?= $prd['precioCaja'] ?>" min="1" disabled></td>
          <td>
            <div id="quitaragregar">
              <button id="editable" type="button" onclick="actualizarStock(<?= $index ?>, 'quitar')" disabled>-</button>
              <input type="number" name="stock[]" id="stock-<?= $index ?>" value="<?= $prd['stock'] ?>" min="0" max="99" readonly>
              <button id="editable" type="button" onclick="actualizarStock(<?= $index ?>, 'agregar')" disabled>+</button>
            </div>
          </td>
          <td><input id="editable" type="checkbox" name="oferta[<?= $index ?>]" value="1" <?= $prd['oferta'] ? 'checked' : '' ?> disabled></td>
          <td>
            <img src="../img/basura.svg" id="basura" onclick="eliminar(<?= $prd['id'] ?>)">
            <img src="../img/imgeditar.png" class="editar" onclick="editar(<?= $prd['id'] ?>)">
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    </form>
  </div>
  <?php include "segments/footer.php" ?>
  <script>
      window.addEventListener("load", (event) => {
        <?php if (!empty($msg)): ?>
            let mensaje = <?= json_encode($msg) ?>;
            mostrarPopup(mensaje, false); // Cambia alert por mostrarPopup
        <?php endif; ?>
    });


    //filtrar por categoria
    const selectFiltroCat = document.getElementById("filtroCat");
    const formCat = document.getElementById("formCat");
    const defaultEstado = localStorage.getItem("defaultEstado2");
    if (defaultEstado !== null) {
      selectFiltroCat.value = defaultEstado;
    }
    selectFiltroCat.addEventListener("change", (event) => {
      localStorage.setItem("defaultEstado2", selectFiltroCat.value);

      formCat.submit();
    });

    function añadirProducto() {
      document.location.href = "/admin/aniadirProducto";
    }

    function editar(id) {
      document.location.href = "/admin/modificarProducto?prdid=" + id;
    }

    function eliminar(id) {
      let confirmacion = confirm("Estas seguro de eliminar el producto?");
      if (confirmacion) {
        document.location.href = "/admin/eliminarProducto?prdid=" + id;
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
      const stockInput = document.getElementById(`stock-${id}`);
      let stock = parseInt(stockInput.value);

      if (accion === 'agregar' && stock < 99) stock++;
      if (accion === 'quitar' && stock > 0) stock--;
      stockInput.value = stock;
    }


    function verificarCamposHabilitados(event) {
    event.preventDefault(); // Prevenir el envío predeterminado del formulario
    const camposEditables = document.querySelectorAll('#editable');
    let todosHabilitados = true;

    camposEditables.forEach(campo => {
        if (campo.disabled) {
            todosHabilitados = false;
            campo.disabled = false;
        }
    });

    if (!todosHabilitados) {
        alert("Algunos campos estaban deshabilitados. Ahora están habilitados. Por favor, revisa los datos y vuelve a enviar.");
        return;
    }

    // Usamos event.target.submit() para enviar el formulario correcto
    event.target.submit();
}


function activarEdicion() {
    const campos = document.querySelectorAll('#editable');
    const editButton = document.getElementById("edicion");
    const habilitar = campos[0].disabled;
    campos.forEach(campo => campo.disabled = !habilitar);
    editButton.textContent = habilitar ? "Desactivar Edición" : "Activar Edición";
}

  </script>