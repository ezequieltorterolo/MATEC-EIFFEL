 <title>Eiffel Importaciones</title>
<link rel="stylesheet" href="/static/css/user_form.css">
 
<div class="form-container">
    <h2><?=$title ?? ucfirst($mode) . " User"?></h2>

    <form id="dataForm" method="POST" action=<?=$action?>>

        <?php if (isset($method)):?>
            <input type="hidden" name="_method" value=<?=$method?>>
        <?php endif ?>

        <div class="form-group">
            <?php if ($mode=="registro"):?>
                <label for="nombre">Nombre:</label>
                <input id="nombre" name="nombre" type="text" placeholder="nombre" value="<?=$name ?? ""?>" required><br><br>
            <?php endif?>

            <label for="email">Email:</label>
            <input id="email" name="email" type="email"  placeholder="email" value="<?=$email ?? ""?>" required><br><br>

            <label for="contraseña">Contraseña:</label>
            <input id="contraseña" name="contraseña" type="password" placeholder="contraseña" required><br><br>

            <?php if ($mode=="registro"):?>
                <label for="repass">Confirme la Contraseña:</label>
                <input id="repass" name="repass" type="password" placeholder="confirme contraseña" required><br><br>

                <label for="direccion">Direccion:</label>
                <input id="direccion" name="direccion" type="text" placeholder="direccion de la empresa/local"><br><br>

                <label for="telefono">Telefono</label>
                <input id="telefono" name="telefono" type="tel" placeholder="telefono de contacto"><br><br>

            <?php endif ?>
        </div>
        <div class="button-group">
        <button>Confirmar <?=$mode?></button>
            <?php if ($mode=="login"):?>
                <p><a href="/registro">Registrarse</a></p>
            <?php else:?>
                <p><a href="/login">Iniciar Sesion</a></p>
            <?php endif?>
            <button type="button" onclick="location.href='/';">Cancelar</button>
        </div>
    </form>
</div>
<script>
    window.addEventListener("load", (event) => {
      <?php if (!empty($msg)): ?>
        let mensaje = <?= json_encode($msg) ?>;
        alert(mensaje);
      <?php endif; ?>
    });
</script>