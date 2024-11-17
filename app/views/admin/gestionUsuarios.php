<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../styles/styles_general.css" rel="stylesheet" type="text/css">
  <link href="../styles/style11.css" rel="stylesheet" type="text/css">
  <link href="../styles/popup.css" rel="stylesheet" type="text/css">
  <script src="../script/reservas.js"></script>
  <meta charset="UTF-8" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Eiffel Importaciones - Usuarios </title>
</head>

<body>



  <div id="titlee" class="container">
    <h1> Usuarios
      <hr>
    </h1>
  </div>

  <div id="todo" class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($usuarios as $user): ?>
        <div class="col-md-3">
          <div class="card">

            <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted">ID DE USUARIO: <?= $user["id"] ?></h6>
              <h5 class="card-title">NOMBRE: <?= $user["nombre"] ?></h5>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Correo electronico: <?= $user["email"] ?></li>
              <li class="list-group-item">Telefono: <?= $user["telefono"] ?></li>
              <li class="list-group-item">Direccion: <?= $user["direccion"] ?></li>
              <li><button class="btn btn-primary" onclick="eliminarUsuario(<?= $user['id'] ?>)">Eliminar Usuario</button></li>
            </ul>
        </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>
  </div>
</body>
<script>
  function eliminarUsuario(id) {
    let confirmacion = confirm("Estas seguro de eliminar este Usuario?");
    if (confirmacion) {
      document.location.href = "/admin/eliminarUsuario?userid=" + id;
    }
  }
</script>
<html>