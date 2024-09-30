<!DOCTYPE html>
<html>
<head> 
    <link href="styles/style.css" rel="stylesheet" type="text/css">
    <script src="scripts/home.js"></script>
    <meta charset="UTF-8" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Eiffel Importaciones</title>
</head>
<body>
    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php" ?>

    <div id="contenedor-destacados"></div>
    <div id="slides">
        <div class="slide showing"></div> 
        <div class="slide"></div>
        <div class="slide"></div>
        
        <div class="arrow">
             <div id="left">
                <img src="img/angle-left.png">
            </div>
            <div id="right">
                <img src="img/angle-right.png">
            </div>
      </div>
    </div>
    <h1 class="subtitulo">OFERTAS</h1>
    <div id="productos-nuevos">
       <?php foreach($ofertas as $prd):?>
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
       
    
    <div id="productos" onclick="redirigir()">
</div>

<?php include  "segments/footer.php" ?>
  


    <script>
        var slides = document.querySelectorAll('#slides .slide');
        var currentSlide = 0;
        function nextSlide() {
            slides[currentSlide].className = 'slide';
            currentSlide = (currentSlide+1)%slides.length;
            slides[currentSlide].className = 'slide showing';
        }

        function previousSlide(){
        slides[currentSlide].className = 'slide';
            currentSlide = (currentSlide+slides.length-1)%slides.length;
            slides[currentSlide].className = 'slide showing';
        }

        document.getElementById("left").onclick = function(){
        previousSlide();
        };
        document.getElementById("right").onclick = function(){
        nextSlide();
        };
    </script>
</body>
</html>