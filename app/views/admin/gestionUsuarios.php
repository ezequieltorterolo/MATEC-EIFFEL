<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../scripts/alertpopup.js"></script> <!-- Incluye el script aquí -->
  <link href="../styles/styles_general.css" rel="stylesheet" type="text/css">
  <link href="../styles/style11.css" rel="stylesheet" type="text/css">
  <link href="../styles/popup.css" rel="stylesheet" type="text/css">
  <link rel="icon"  href="../img/logito.ico">
  <meta charset="UTF-8" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Eiffel Importaciones - Gestión de Usuarios</title>
</head>

<body>
  <?php include "segments/header.php" ?>
  <div id="titulo" class="container-fluid">
    <div class="row">
      <div class="col-12 text-left mt-3">
        <h2> Gestión de Usuarios </h2>
      </div>
      <hr>
      <div class="col-4 mt-3 mb-3" id="atras">
        <p><img src="../img/angle-left.png"><a href="/admin"> Volver atras </a></p>
      </div>
    </div>
  </div>
  <div id="tabla-prod">
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Direccion</th>
          <th>Telefono</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $user): ?>
          <tr>
            <td><?= $user["id"]?></td>
            <td><?= $user["nombre"]?></td>
            <td><?= $user["email"]?></td>
           <td><?php if($user["direccion"] == 0):?>N/A<?php else:?> <?=$user["direccion"]?><?php endif;?></td>

            <td><?= $user["telefono"]?></td>
            <td>
            <button type="button" id="eliminar" class="btn btn-primary" onclick="eliminarUsuario(<?= $user['id'] ?>)">Eliminar</button>
            </td>
          </tr>
          <?php endforeach;?>
      </tbody>
    </table>
    </div>

    <?php include "segments/footer.php" ?>

<script>
     window.addEventListener("load", (event) => {
        <?php if (!empty($msg)): ?>
            let mensaje = <?= json_encode($msg) ?>;
            mostrarPopup(mensaje, false); // Cambia alert por mostrarPopup
        <?php endif; ?>
    });

  function eliminarUsuario(id) {
    let confirmacion = confirm("Estas seguro de eliminar este Usuario?");
    if (confirmacion) {
      document.location.href = "/admin/eliminarUsuario?userid=" + id;
    }
  }
</script>
<html>