<header>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    


    <img src="img/logo.jpg">

<div class="cont-menu">    
    <form class="cont-buscador"  action="/catalogo" method="GET">
        <input  id ="buscador" type="text" name="nombre" placeholder="Buscar...">
        <input type="image" id="lupa" src="img/lupa.svg" style="width:25px; height:25px;">
    </form>
    <div class="cont-opciones-header">
        <?php if (isset($_SESSION["usuario"])): ?>
            <li><h3><?=$_SESSION["usuario"]["nombre"]?></h3>
            <div class="cont-cerrar-sesion">
                    <li onclick="cerrarSesion(<?=$_SESSION['usuario']['id']?>)"><h3>Cerrar sesion</a></li>
            </div>
            </li>
        <?php else: ?>
        <a href="/login"> <img src="img/avatar-user.svg" style="width:35px; height:35px;"> </a>
        <?php endif?>
        <a href="carrito"> <img src="img/carrito.svg" style="width:35px; height:35px;"> <div id="badge-carrito" class="badge bg-danger">0</div> </a>
    </div>
</header>
<script>

window.addEventListener("load", function() {
    const contenidoGuardado = localStorage.getItem("contenidoDiv");
    if (contenidoGuardado) {
        document.getElementById("badge-carrito").innerHTML = contenidoGuardado;
    }
});
    

    function cerrarSesion(id){
        document.location.href= "/logout?usuarioid="+id;
    };

    $("#lupa").mouseenter(function(){
        $("#lupa").css("opacity", "1");
        $("#lupa").css("transform", "scale(1.1");
    });

    $("#lupa").mouseleave(function(){
        $("#lupa").css("opacity", "0.8");
        $("#lupa").css("transform", "scale(1");
    });

    $( "#lupa" ).click(function() {
        $( ".cont-buscador" ).submit(); 
     });


   
</script>


</div>