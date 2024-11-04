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
     <link href="styles/style.css" rel="stylesheet" type="text/css">
    <title>Eiffel Importaciones</title>
    

</head>
<body>
    


    <?php include  "segments/header.php" ?>
    <?php include  "segments/nav.php" ?>

    <div id="contenedor-destacados" class="container-fluid"></div>
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
    <div id="productos-nuevos" class="container">
       <?php foreach($ofertas as $prd):?>
            <div class="producto-posicion">
                <a href =/producto?id=<?=$prd["id"]?>><img class="img-prod" src=img/<?=$prd["imagen"]?>></a>
                <p class="nombre-prod"><?=$prd["nombre"]?></p>
                <p class="precio-prod"><?php if(isset($prd["precioCaja"])): ?>
                    $<?=$prd["precioCaja"]?> Al por mayor -
                    <?php else: ?>
                    &nbsp
                     <?php endif; ?>$<?=$prd["precio"]?> c/u </p>
            </div>
            <?php endforeach?>
    </div>
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
