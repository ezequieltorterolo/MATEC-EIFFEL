<title>Eiffel Importaciones</title>
<link rel="stylesheet" href="/static/css/user_form.css">

<div class="form-container">
    <h2><?= $title ?? ucfirst($mode) ?></h2>

    <form id="dataForm" method="POST" action=<?= $action ?>>

        <?php if (isset($method)): ?>
            <input type="hidden" name="_method" value=<?= $method ?>>
        <?php endif ?>
        <?php if (isset($mode)): ?>
            <input type="hidden" name="modo" value=<?=$mode ?>>
        <?php endif ?>
        <input type="hidden" name="id" <?php if (isset($prd)):?>value="<?=$prd["id"] ?><?php endif?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input id="nombre" name="nombre" type="text" placeholder="nombre" <?php if (isset($prd)): ?>value="<?= $prd["nombre"] ?><?php endif ?>"><br><br>

            <label for="descripcion">Descripcion:</label>
            <input id="descripcion" name="descripcion" type="text" placeholder="descripcion" <?php if (isset($prd)): ?>value="<?= $prd["descripcion"] ?><?php endif ?>"><br><br>

            <label for="precio">Precio:</label>
            <input id="precio" name="precio" type="text" placeholder="precio" <?php if (isset($prd)): ?>value="<?= $prd["precio"] ?><?php endif ?>"><br><br>

            <label for="precioCaja">Precio Caja:</label>
            <input id="precioCaja" name="precioCaja" type="text" placeholder="precio Caja" <?php if (isset($prd)): ?>value="<?= $prd["precioCaja"] ?><?php endif ?>"><br><br>

            <label for="categoria">Categoria:</label>
            <select name="categoria">
                <option>Categoria 1</option>
                <option>Categoria 2</option>
                <option>Categoria 3</option>
            </select><br><br>

            <label for="subcategoria">Subcategoria:</label>
            <select name="subcategoria">
                <option>SubCategoria 1</option>
                <option>Subcategoria 2</option>
                <option>Subcategoria 3</option>
            </select><br><br>

            <label for="stock">Stock:</label>
            <input id="stock" name="stock" type="text" placeholder="stock" <?php if (isset($prd)): ?>value="<?= $prd["stock"] ?><?php endif ?>"><br><br>

            <label for="oferta">Oferta:</label>
            <input id="oferta" name="oferta" type="checkbox" <?php if (isset($prd)): ?> <?= $prd['oferta'] == 1 ? 'checked' : ''?><?php endif ?>><br><br>

            <label for="cantidadCaja">Cantidad Caja:</label>
            <input id="cantidadCaja" name="cantidadCaja" type="text" placeholder="cantidadCaja" <?php if (isset($prd)): ?>value="<?= $prd["cantidadCaja"] ?><?php endif ?>"><br><br>

            <label for="imagen"> Imagen:</label>
            <input id="imagen" name="imagen" type="file"><br><br>
            <div id="container-imagen">
                <img id="preview" <?php if (isset($prd)):?>src="../img/<?= $prd["imagen"] ?><?php endif ?>" alt="Vista previa de la imagen" width="300px"></img>
            </div>
        </div>

        <?php if (!empty($msg)): ?>
            <div class="divmsg">
                <div><?= $msg ?></div>
            </div>
        <?php endif ?>
        <div class="button-group">
            <button>Confirmar</button>
            <button type="button" onclick="location.href='admin/gestionProductos';">Cancelar</button>
        </div>
        <script> 
                const imagen = document.getElementById("imagen");
                const preview = document.getElementById('preview');

                imagen.addEventListener('change', (event) => {
                    const archivo = event.target.files[0];

                    if (archivo) {
                        const lector = new FileReader(); 

                        lector.onload = (e) => {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };

                        lector.readAsDataURL(archivo)
                    }
                });
        </script>
    </form>
</div>