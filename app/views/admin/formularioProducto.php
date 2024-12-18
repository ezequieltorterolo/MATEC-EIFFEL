<title>Eiffel Importaciones</title>
<link href="../styles\style12.css" rel="stylesheet" type="text/css">
<script src="../scripts/alertpopup.js"></script> <!-- Incluye el script aquí -->

<body>
    <div class="form-container">


        <form id="dataForm" method="POST" action=<?= $action ?> enctype="multipart/form-data">
            <div class="col-4 mt-3 mb-3" id="atras" onclick="history.back()">
                <p><img src="../img/angle-left.png"></p>
            </div>
            <h2><?= $title ?? ucfirst($mode) ?></h2>

            <?php if (isset($method)): ?>
                <input type="hidden" name="_method" value=<?= $method ?>>
            <?php endif ?>
            <?php if (isset($mode)): ?>
                <input type="hidden" name="modo" value=<?= $mode ?>>
            <?php endif ?>
            <input type="hidden" name="id" <?php if (isset($prd)): ?>value="<?= $prd["id"] ?><?php endif ?>">
            <div class="form-group">
                <label for="nombre">Nombre: </label>
                <input id="nombre" name="nombre" type="text" placeholder="nombre" <?php if (isset($prd)): ?>value="<?= $prd["nombre"] ?><?php endif ?>" required><br><br>

                <label for="descripcion">Descripcion: </label>
                <input id="descripcion" name="descripcion" type="text" placeholder="descripcion" <?php if (isset($prd)): ?>value="<?= $prd["descripcion"] ?><?php endif ?>" required><br><br>

                <label for="precio">Precio: </label>
                <input id="precio" name="precio" type="text" placeholder="precio" <?php if (isset($prd)): ?>value="<?= $prd["precio"] ?><?php endif ?>" required><br><br>

                <label for="precioCaja">Precio Caja: </label>
                <input id="precioCaja" name="precioCaja" type="text" placeholder="precio Caja" <?php if (isset($prd)): ?>value="<?= $prd["precioCaja"] ?><?php endif ?>" required><br><br>

                <label for="categoria">Categoria: </label>
                <select id="categoria" name="categoria_id">
                    <option value="0" <?php if ($mode == "addprd"): ?>default <?php endif; ?>>Seleccione una Categoria</option>
                    <?php foreach ($categoria as $catego): ?>
                        <option value="<?= $catego["id"] ?>"><?= $catego["nombreCategoria"] ?></option>
                    <?php endforeach ?>
                    <option>Nueva Categoría</option>
                </select required><br><br>
                <input type="hidden" id="categoria2" name="categoria2" placeholder="nueva categoria">

                <label for="subcategoria">SubCategoria: </label>
                <select id="subcategoria" name="subcategoria_id">
                    <option value="0" <?php if ($mode == "addprd"): ?>default <?php endif; ?>>Seleccione una SubCategoria</option>
                    <?php foreach ($subcategoria as $subCatego): ?>
                        <option value="<?= $subCatego["id"] ?>"><?= $subCatego["nombreSubCategoria"] ?></option>
                    <?php endforeach ?>
                    <option>Nueva SubCategoría</option>
                </select required><br><br>
                <input type="hidden" id="subcategoria2" name="subcategoria2" placeholder="nueva subcategoria">

                <label for="stock">Stock: </label>
                <input id="stock" name="stock" type="text" placeholder="stock" <?php if (isset($prd)): ?>value="<?= $prd["stock"] ?><?php endif ?>" required><br><br>


                <label for="oferta">Oferta: </label>
                <input id="oferta" name="oferta" type="checkbox" <?php if (isset($prd)): ?> <?= $prd['oferta'] == 1 ? 'checked' : '' ?><?php endif ?>><br><br>

                <label for="cantidadCaja">Cantidad Caja: </label>
                <input id="cantidadCaja" name="cantidadCaja" type="text" placeholder="cantidadCaja" <?php if (isset($prd)): ?>value="<?= $prd["cantidadCaja"] ?><?php endif ?>"><br><br>

                <label for="imagen"> Imagen: </label>
                <input id="imagen" name="imagen" type="file" <?php if (!isset($prd)): ?>required <?php endif; ?>><br><br>
                <div id="container-imagen">
                    <label>Vista previa de la imagen: </label>
                    <div class="containerImagen">
                        <img id="preview" <?php if (isset($prd)): ?>src="../img/<?= $prd["imagen"] ?><?php endif; ?>" alt="Vista previa de la imagen" width="300px"></img>
                    </div>
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
                    if (opcionSeleccionada.includes("Nueva Categoría")) {
                        categoriaInput.type = "text";
                    } else {
                        categoriaInput.type = "hidden";
                    }
                });
                const subCategoriaSelect = document.getElementById("subcategoria");
                const subCategoriaInput = document.getElementById("subcategoria2");

                subCategoriaSelect.addEventListener("change", function() {

                    const opcionSeleccionada = subCategoriaSelect.options[subCategoriaSelect.selectedIndex].text;
                    if (opcionSeleccionada.includes("Nueva SubCategoría")) {
                        subCategoriaInput.type = "text";
                    } else {
                        subCategoriaInput.type = "hidden";
                    }
                });
                window.addEventListener("load", (event) => {
                    <?php if (!empty($msg)): ?>
                        let mensaje = <?= json_encode($msg) ?>;
                        mostrarPopup(mensaje, false); // Cambia alert por mostrarPopup
                    <?php endif; ?>
                });
            </script>
        </form>
    </div>
</body>