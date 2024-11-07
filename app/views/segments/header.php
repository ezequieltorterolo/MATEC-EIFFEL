<header>


    <img src="img/logo.jpg">

<div class="cont-menu" style="display: flex;">    
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
        <a href="/login"> <img class="icono-principal" src="img/avatar-user.svg" style="width:35px; height:35px;"> <img class="icono-alternativo" src="img/avatar-user-relleno.svg" style="width:35px; height:35px;"> </a>
        <?php endif?>
        <a href="carrito"> <img class="icono-principal"  src="img/carrito.svg" style="width:35px; height:35px;"><img class="icono-alternativo" src="img/carrito-relleno.svg" style="width:35px; height:35px;"> <div id="badge-carrito" class="badge bg-danger"></div> </a>
    </div>
    <script>
    const iconosPrincipales = document.querySelectorAll(".icono-principal");
    iconosPrincipales.forEach(iconosPrincipales => {
    const iconoAlternativo = iconosPrincipales.nextElementSibling;
    iconoAlternativo.style.display = "none";
    

    function mostrarIconoAlternativo() {
        iconosPrincipales.style.display = "none";
        iconoAlternativo.style.display = "inline-block";
    }

    function mostrarIconoPrincipal() {
        iconosPrincipales.style.display = "inline-block";
        iconoAlternativo.style.display = "none";
    }

        iconosPrincipales.addEventListener("mouseover", mostrarIconoAlternativo);
        iconoAlternativo.addEventListener("mouseout", mostrarIconoPrincipal);
    });
    </script>
</header>
<script>
  function mostrarCantidadP(){
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let cantidadCarrito = carrito.length; 
    localStorage.setItem("contenidoDiv", cantidadCarrito);
    document.getElementById("badge-carrito").innerHTML = cantidadCarrito;

           }
window.addEventListener("load", function() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let cantidadCarrito = carrito.length; 
    localStorage.setItem("contenidoDiv", cantidadCarrito);
    document.getElementById("badge-carrito").innerHTML = cantidadCarrito;
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