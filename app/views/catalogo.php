<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link href="styles/style3.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>CATÁLOGO</title>
</head>

<body>
    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php"    ?>

    <div id="body-catalogo">
        <div id="seccion-titulo">
            <h1>CATÁLOGO</h1>
            <hr>
        </div>
        <div id="seccion-filtros">
            <h3>Ordenar por:</h3>
            <select name="ordenar">
                <option value="predeterminado" selected>Predeterminado</option>
                <option value="orden-a-z">Nombre (A-Z)</option>
                <option value="orden-z-a">Nombre (Z-A)</option>
            </select>
            <p><?=$totrec?> productos encontrados.</p>
        </div>


        <hr id="hr-catalogo">
        <div id="productos-nuevos">
        <?php foreach($data as $prd):?>
            <div class="producto-posicion">
                <a href =/producto?id=<?=$prd["id"]?>><img class="img-prod" src=img/<?=$prd["imagen"]?>></a>
                <p class="nombre-prod"><?=$prd["nombre"]?></p>
                <p class="precio-prod"><?php if(isset($prd["precioMayor"])): ?>
                    $<?=$prd["precioMayor"]?> Al por mayor -
            <?php else: ?>
                &nbsp
            <?php endif; ?>$<?=$prd["precio"]?> c/u </p>
            </div>
        <?php endforeach?>
        
    </div>
    <?php include  "segments/footer.php" ?>
</body>

</html>