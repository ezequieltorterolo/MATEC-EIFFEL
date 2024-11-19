<!DOCTYPE html>
<html lang="es">
<html>
<head> 
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
  

<<<<<<< HEAD
    <h1 id="subtituloHome" class="subtitulo ofertas">OFERTAS <hr style="max-width:30%; margin:auto; margin-top:5px;"></h1>
=======
    <h1 class="subtitulo ofertas">OFERTAS </h1>

</br>
</br>
>>>>>>> 71411e762713283548cf53d1fd97d8bd5391e42e
   
    <div id="productos-nuevos" class="container">
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

<br> <br>
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

        function hacerQueAparezca(){
        var contHome = document.getElementById("productos-nuevos");
        var subHome = document.getElementById("subtituloHome");
        subHome.style.opacity = 0;
        subHome.style.transform = "translateY(20px)";
        subHome.style.transition = "all 0.3s linear";

        contHome.style.opacity = 0;
        contHome.style.transform = "translateY(20px)";
        contHome.style.transition = "all 0.3s linear";

        var distanciaOfertas = window.innerHeight - contHome.getBoundingClientRect().top;
        var distanciaSubtitulo = window.innerHeight - subHome.getBoundingClientRect().top;
        if(distanciaOfertas > 300){
            contHome.style.opacity = 1;
            contHome.style.transform = "translateY(0px)";
        } 
        if(distanciaSubtitulo > 150){
            subHome.style.opacity = 1;
            subHome.style.transform = "translateY(0px)";
        }
    }
    window.addEventListener("scroll", hacerQueAparezca);


    </script>
</body>
</html>
