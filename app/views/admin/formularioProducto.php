<title>Eiffel Importaciones</title>
<link rel="stylesheet" href="/static/css/user_form.css">

<div class="form-container">
    <h2><?= $title ?? ucfirst($mode) ?></h2>

    <form id="dataForm" method="POST" action=<?= $action ?> enctype="multipart/form-data">

        <?php if (isset($method)): ?>
            <input type="hidden" name="_method" value=<?= $method ?>>
        <?php endif ?>
        <?php if (isset($mode)): ?>
            <input type="hidden" name="modo" value=<?= $mode ?>>
        <?php endif ?>
        <input type="hidden" name="id" <?php if (isset($prd)): ?>value="<?= $prd["id"] ?><?php endif ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input id="nombre" name="nombre" type="text" placeholder="nombre" <?php if (isset($prd)): ?>value="<?= $prd["nombre"] ?><?php endif ?>" required><br><br>

            <label for="descripcion">Descripcion:</label>
            <input id="descripcion" name="descripcion" type="text" placeholder="descripcion" <?php if (isset($prd)): ?>value="<?= $prd["descripcion"] ?><?php endif ?>" required><br><br>

            <label for="precio">Precio:</label>
            <input id="precio" name="precio" type="text" placeholder="precio" <?php if (isset($prd)): ?>value="<?= $prd["precio"] ?><?php endif ?>" required><br><br>

            <label for="precioCaja">Precio Caja:</label>
            <input id="precioCaja" name="precioCaja" type="text" placeholder="precio Caja" <?php if (isset($prd)): ?>value="<?= $prd["precioCaja"] ?><?php endif ?>" required><br><br>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria">
                <option <?php if ($mode == "addprd"): ?>default <?php endif; ?>>Seleccione una categoria</option>
                <?php foreach ($categoria as $catego): ?>
                    <option><?= $catego["nombreCategoria"] ?></option>
                <?php endforeach ?>
                <option>Nueva categoría</option>
                <input type="hidden" id="categoria2" name="categoria2" placeholder="nueva categoria">
            </select required><br><br>

            <label for="subcategoria">Subcategoria:</label>
            <select name="subcategoria">
                <option>Jabones</option>
                <option>Salsas</option>
                <option>Toallas</option>
            </select required><br><br>

            <label for="stock">Stock:</label>
            <input id="stock" name="stock" type="text" placeholder="stock" <?php if (isset($prd)): ?>value="<?= $prd["stock"] ?><?php endif ?>" required><br><br>

            <label for="oferta">Oferta:</label>
            <input id="oferta" name="oferta" type="checkbox" <?php if (isset($prd)): ?> <?= $prd['oferta'] == 1 ? 'checked' : '' ?><?php endif ?>><br><br>

            <label for="cantidadCaja">Cantidad Caja:</label>
            <input id="cantidadCaja" name="cantidadCaja" type="text" placeholder="cantidadCaja" <?php if (isset($prd)): ?>value="<?= $prd["cantidadCaja"] ?><?php endif ?>"><br><br>

            <label for="imagen"> Imagen:</label>
            <input id="imagen" name="imagen" type="file" <?php if (!isset($prd)): ?>required <?php endif; ?>><br><br>
            <div id="container-imagen">
                <img id="preview" <?php if (isset($prd)): ?>src="../img/<?= $prd["imagen"] ?><?php endif; ?>" alt="Vista previa de la imagen" width="300px"></img>
            </div>
        </div>
        <div class="button-group">
            <button>Confirmar</button>
            <button type="button" onclick="location.href='/admin/gestionProductos';">Cancelar</button>
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

            const categoriaSelect = document.getElementById("categoria");
            const categoriaInput = document.getElementById("categoria2");

            categoriaSelect.addEventListener("change", function() {
                const opcionSeleccionada = categoriaSelect.options[categoriaSelect.selectedIndex].text;
                if (opcionSeleccionada.includes("Nueva categoría")) {
                    categoriaInput.type = "text";
                } else {
                    categoriaInput.type = "hidden";
                }
            });
            window.addEventListener("load", (event) => {
                <?php if (!empty($msg)): ?>
                    let mensaje = <?= json_encode($msg) ?>;
                    alert(mensaje);
                <?php endif; ?>
            });
        </script>
    </form>
</div>