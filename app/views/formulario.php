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
  
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="styles/alertpopup.css" rel="stylesheet" type="text/css">
     <link href="styles/stylelog.css" rel="stylesheet" type="text/css">

    <title>Eiffel Importaciones</title>
    

</head>
<body>


<div id="carcel" class="container">
<div id="imagen" class="container-fluid">
  <img class="img-fluid" src="/img/logo.jpg">
</div>




<div class="container" id="page">



<div id="login" class="container  d-flex justify-content-center align-items-center">
    <div class="row">
    <form id="dataForm" method="POST" action=<?=$action?>>

        <?php if (isset($method)):?>
            <input type="hidden" name="_method" value=<?=$method?>>
        <?php endif ?>

        <div class="form-group">
        <div class="row">
            <?php if ($mode=="registro"):?>
                <label for="nombre">Nombre:</label>
                <input id="nombre" name="nombre" type="text" placeholder="nombre" value="<?=$name ?? ""?>" required><br><br>
            <?php endif?>
            </div>
            <div class="row">
            <label for="email">Correo electronico:</label>
            <input id="email" name="email" type="email"  placeholder="email" value="<?=$email ?? ""?>" required><br><br>
            </div> </div>
            <div class="row">
            <label for="contraseña">Contraseña</label>
            <input id="contraseña" name="contraseña" type="password" placeholder="contraseña" required><br><br>
            </div>
            <?php if ($mode=="registro"):?>
                <div class="row">
                <label for="repass">Confirme la contraseña</label>
                <input id="repass" name="repass" type="password" placeholder="confirme contraseña" required><br><br>
            </div>
            <div class="row">
                <label for="direccion">Direccion</label>
                <input id="direccion" name="direccion" type="text" placeholder="direccion de la empresa/local"><br><br>
            </div>
            <div class="row">
                <label for="telefono">Numero de telefono</label>
                <input id="telefono" name="telefono" type="tel" placeholder="telefono de contacto"><br><br>
            </div>
            <?php endif ?>
        </div>
            </div>
            <hr>
            
        <div class="button-group container" id="botones">
        <div class="row">
        <button  class="botones" >Confirmar <?=$mode?></button>
            <?php if ($mode=="login"):?> 
                <p><a href="/registro">Registrarse</a></p>
            <?php else:?>
                <p><a href="/login">Iniciar Sesion</a></p>
            <?php endif?>
            </div>
            <div class="row">
            <button type="button"  class="botones" onclick="location.href='/';">Cancelar</button>
            </div>
        </div>
    </form>
</div>
            </div></div>
            </div>

<script>
    window.addEventListener("load", (event) => {
      <?php if (!empty($msg)): ?>
        let mensaje = <?= json_encode($msg) ?>;
        mostrarPopup(mensaje,false);
      <?php endif; ?>
    });


        
     src="scripts/alertpopup.js"



</script>

</body>
</html>