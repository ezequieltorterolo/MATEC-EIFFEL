
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<header>


  <a href="/">  <img src="img/logomenu.png" > </a>

<div class="cont-menu" style="display:flex;">    
    <form class="cont-buscador"  action="/catalogo" method="GET">
        <input  id ="buscador" type="text" name="nombre" placeholder="Buscar...">
        <input type="image" id="lupa" src="img/lupa.svg" style="width:25px; height:25px;">
    </form>
    <div class="cont-opciones-header">
        <?php if (isset($_SESSION["usuario"])): ?>
        <div class="cont-sesion-nombre-y-foto">
            <img class="icono-alternativo-logueado" src="img/avatar-user-relleno.svg" style="width:35px; height:35px;">
            <ul class="submenu-logueado">
                <li><p class="esconder-nombre"><?=$_SESSION["usuario"]["nombre"]?></p></li>
                <li><a class="esconder-nombre" href="/verReservas">Ver mis Reservas</a></li>
                <li><a class="esconder-nombre" onclick="cerrarSesion(<?=$_SESSION['usuario']['id']?>)">Cerrar sesion</a></li>
            </ul>
        </div>
        <?php else: ?>

        <a class="login-usuario-margin"  href="/login"> <img class="icono-principal" src="img/avatar-user.svg" style="width:35px; height:35px;"> <img class="icono-alternativo" src="img/avatar-user-relleno.svg" style="width:35px; height:35px;"> </a>
        <?php endif?>
        <a href="carrito"> <img class="icono-principal"  src="img/carrito.svg" style="width:35px; height:35px;"><img class="icono-alternativo" src="img/carrito-relleno.svg" style="width:35px; height:35px;"> <div id="badge-carrito" class="badge bg-danger"></div> </a>
    </div>
    <script>
    // const submenuLogueado = document.getElementById(".submenu-logueado");
    // submenuLogueado.style.display = "none";
    const iconoAlternativoLogueado = document.getElementById(".icono-alterativo-logueado");
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

    // function mostrarSubmenuLogueado() {
    //     submenuLogueado.style.display = "block";
    // }

    // iconoAlternativoLogueado.addEventListener("mouseover", mostrarSubmenuLogueado);
    </script>
</header>

<script>
    function mostrarCantidadP() {w
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


    function cerrarSesion(id) {
        document.location.href = "/logout?usuarioid=" + id;
    };




    $("#lupa").mouseenter(function(){
        $("#lupa").css("opacity", "1");
        $("#lupa").css("transform", "scale(1.1");
    });

    $("#lupa").mouseleave(function() {
        $("#lupa").css("opacity", "0.8");
        $("#lupa").css("transform", "scale(1");
    });

    $("#lupa").click(function() {
        $(".cont-buscador").submit();
    });
</script>


</div>