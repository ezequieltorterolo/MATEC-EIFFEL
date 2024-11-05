 
 <!DOCTYPE html>
<html lang="es">
<html>
<head> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/home.js"></script>
    <meta charset="UTF-8" />
     <link href="styles/styles_general.css" rel="stylesheet" type="text/css">
      <link href="styles/style9.css" rel="stylesheet" type="text/css">
   
  
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   
    <title>Eiffel Importaciones</title>
    

</head>
<body>

<?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php" ?>

<div class="container-fluid" id="page">

<div id="title" class="container">
    <h1><?=$title ?? ucfirst($mode) . " User"?></h1>
    <hr>
</div>


<div id="login" class="container d-flex justify-content-center align-items-center">
    <div class="row">
    <form id="dataForm" method="POST" action=<?=$action?>>

        <?php if (isset($method)):?>
            <input type="hidden" name="_method" value=<?=$method?>>
        <?php endif ?>

        <div class="form-group">
        <div class="row">
            <?php if ($mode=="registro"):?>
                <label>for="nombre">Nombre:</label>
                <input id="nombre" name="nombre" type="text" placeholder="nombre" value="<?=$name ?? ""?>" required><br><br>
            <?php endif?>
            </div>
            <div class="row">
            <label for="email">Email:</label>
            <input id="email" name="email" type="email"  placeholder="email" value="<?=$email ?? ""?>" required><br><br>
            </div> </div>
            <div class="row">
            <label for="contraseña">Contraseña:</label>
            <input id="contraseña" name="contraseña" type="password" placeholder="contraseña" required><br><br>
            </div>
            <?php if ($mode=="registro"):?>
                <div class="row">
                <label for="repass">Confirme la Contraseña:</label>
                <input id="repass" name="repass" type="password" placeholder="confirme contraseña" required><br><br>
            </div>
            <div class="row">
                <label for="direccion">Direccion:</label>
                <input id="direccion" name="direccion" type="text" placeholder="direccion de la empresa/local"><br><br>
            </div>
            <div class="row">
                <label for="telefono">Telefono</label>
                <input id="telefono" name="telefono" type="tel" placeholder="telefono de contacto"><br><br>
            </div>
            <?php endif ?>
        </div>
            </div>
            
        <div class="button-group container" id="botones">
        <div class="row">
        <button  class="btn btn-primary" >Confirmar <?=$mode?></button>
            <?php if ($mode=="login"):?> 
                <p><a href="/registro">Registrarse</a></p>
            <?php else:?>
                <p><a href="/login">Iniciar Sesion</a></p>
            <?php endif?>
            </div>
            <div class="row">
            <button type="button"  class="btn btn-primary" onclick="location.href='/';">Cancelar</button>
            </div>
        </div>
    </form>
</div>
            </div></div>

<?php include  "segments/footer.php" ?>

<script>
    window.addEventListener("load", (event) => {
      <?php if (!empty($msg)): ?>
        let mensaje = <?= json_encode($msg) ?>;
        alert(mensaje);
      <?php endif; ?>
    });
</script>

</body>
</html>