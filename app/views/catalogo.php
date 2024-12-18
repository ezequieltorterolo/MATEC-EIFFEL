<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta charset="UTF-8" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> </script>


    <link href="styles/style3.css" rel="stylesheet" type="text/css">
    <link href="styles/styles_general.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon"  href="../img/logito.ico">
    <title>CATÁLOGO</title>
</head>

<body>
    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php"    ?>

    <div id="body-catalogo">
        <div id="seccion-titulo">
            <!-- <?php foreach($categoria as $cate):?>
               <h1 class="subtitulo"><?=$cate["nombreCategoria"]?></h1>
            <?php endforeach?> -->
            <h1 class="subtitulo">CATÁLOGO</h1>
            <hr>
        </div>



        <form id="seccion-filtros"  method="POST">
            <h3>Ordenar por:</h3>
            <select name="ordenarPor" onchange=submit()>
                <option value="id"          <?=($ordenadoPor == "id"          )?  "selected":"" ?>>Predeterminado</option>
                <option value="nombre ASC"  <?=($ordenadoPor == "nombre ASC"  )?  "selected":"" ?>>Nombre (A-Z)</option>
                <option value="nombre DESC" <?=($ordenadoPor == "nombre DESC" )?  "selected":"" ?>>Nombre (Z-A)</option>
                <option value="precio ASC"  <?=($ordenadoPor == "precio ASC"  )?  "selected":"" ?>>Precio (Menor a Mayor)</option>
                <option value="precio DESC" <?=($ordenadoPor == "precio DESC" )?  "selected":"" ?>>Precio (Mayor a Menor)</option>
            </select>
            <p id="total-productos"><?=$totrec?> productos encontrados.</p>
        </form>


        <div id="seccion-productos-linea">
        <hr id="hr-catalogo">
        <div id="productos-nuevos">
            <?php foreach($data as $prd):?>
                <div class="producto-posicion">
                    <a href =/producto?id=<?=$prd["id"]?>><img class="img-prod" src=img/<?=$prd["imagen"]?>></a>
                    <a href=/producto?id=<?=$prd["id"]?>><p class="nombre-prod" title="<?=$prd["nombre"]?>"><?= (strlen($prd["nombre"]) > 35) ? substr($prd["nombre"], 0, 35) . "..." : $prd["nombre"] ?></p></a>
                    <p class="precio-prod">
                        <?php if(isset($prd["precioCaja"])): ?>
                            $<?=$prd["precioCaja"]?> Al por mayor -
                        <?php else: ?>
                            &nbsp
                        <?php endif; ?>
                        $<?=$prd["precio"]?> c/u </p>
                </div>
            <?php endforeach?>
        </div>
       </div>
    </div>
                    
    <?php include  "segments/footer.php" ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var contSubtitulo = document.getElementById("seccion-titulo");
            var contFiltro = document.getElementById("seccion-filtros");
            var contProductos = document.getElementById("seccion-productos-linea");
            var contProductosSinLinea = document.getElementById("productos-nuevos");

            contSubtitulo.style.opacity = 0;
            contSubtitulo.style.transition = "all 1s linear";

            contFiltro.style.opacity = 0;
            contFiltro.style.transition = "all 1s linear";

            contProductos.style.opacity = 0;
            contProductos.style.transition = "all 1s linear";

            contProductosSinLinea.style.opacity = 0;
            contProductosSinLinea.style.transform = "translateY(20px)";
            contProductosSinLinea.style.transition = "all 0.5s linear";
            

            setTimeout(function () {
                contSubtitulo.style.opacity = 1;
            }, 100);

            setTimeout(function () {
                contFiltro.style.opacity = 1;
            }, 120);

            setTimeout(function () {
                contProductos.style.opacity = 1;
            }, 140);

            setTimeout(function () {
                contProductosSinLinea.style.opacity = 1;
                contProductosSinLinea.style.transform = "translateY(0px)";
            }, 160);
        });

    </script>
</body>
</html>