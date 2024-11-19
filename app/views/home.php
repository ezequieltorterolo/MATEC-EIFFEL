<!DOCTYPE html>
<html lang="es">
<html>
<head> 
<link rel="icon"  href="../img/logito.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">



 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts/home.js"></script>
    <script src="rutex.js"></script>
    <meta charset="UTF-8" />
    <link href="styles/styles_general.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <link href="styles/style.css" rel="stylesheet" type="text/css">
    <title>Eiffel Importaciones</title>

   
    

</head>
<body>
  
    <?php include  "segments/header.php" ?>
    
    <?php include  "segments/nav.php" ?>
    <div id="caratula">
            <a href="/catalogo?catego=2"><img id="foto-caratula" src="img/caratulaBanner.gif"></a>
    </div>
  

    <h1 class="subtitulo ofertas">OFERTAS</h1>
   
    <div id="cont-productos-home" class="container">
            <?php foreach($ofertas as $prd):?>
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
<?php include  "segments/footer.php" ?>
  


    <script>
        function hacerQueAparezca(){
        var contHome = document.getElementById("cont-productos-home");
        contHome.style.opacity = 0;
        contHome.style.transform = "translateY(20px)";
        contHome.style.transition = "all 0.3s linear";
        var distanciaOfertas = window.innerHeight - contHome.getBoundingClientRect().top;

        if(distanciaOfertas > 150){
            contHome.style.opacity = 1;
            contHome.style.transform = "translateY(0px)";
            console.log(distanciaOfertas);
        };
    };
    window.addEventListener("scroll", hacerQueAparezca);


    </script>
</body>
</html>
