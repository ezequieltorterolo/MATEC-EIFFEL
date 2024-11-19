<?php
use app\models\Categoria;

  $catego    = new Categoria;
  $categoria = $catego->getall();
?>


<nav class="navegacion">

<div id="pantalla-grande">
    <ul class="menu nav">
        
        <li class="nav-item elemento-lista">
          <a href="/">INICIO</a>
        </li>

        <li class="nav-item dropdown elemento-lista">
            <a class="nav-link" data-bs-toggle="dropdown">CATEGORIAS</a>
            <ul class="dropdown-menu">
                <?php foreach($categoria as $cate):?>
                  <li> <a class="dropdown-item"  href="/catalogo?catego=<?=$cate["id"]?>"><?=$cate["nombreCategoria"]?></a></li> <li><hr class="dropdown-divider"></li>
                <?php endforeach?>
            </ul>
        </li>
   
        <li class="nav-item elemento-lista"><a href="/catalogo">CATALOGO</a></li> 
           
        <li class="nav-item elemento-lista"><a href="/sobreNosotros"> SOBRE NOSOTROS </a></li>
   
    </ul>

                </div>
           
 
    <div class="iconos" style="display:none;">
      <div class="derecha"> 
        
        <button>
          <!-- Carrito -->
          <a href="carrito" style="color:rgba(37,49,65,1);">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
          </svg>
          <div id="badge-carrito" class="badge bg-danger" style="position: relative; right: 15px; bottom: 10px;"> <p id="carr-cantidad" style="margin:-1px; font-weight:bold;"> </p><!-- Aqui esta la badge de carrito en la vista movil-->
                </div>
                </a>
        </button>

        <!-- Login -->

        <?php if (isset($_SESSION["usuario"])): ?>
          <button>
            <img src="img/user-solid.svg" onclick="abrirMenu()">
            <div class="submenu-logueado">
          
                <li><p class="mt-2"><?=$_SESSION["usuario"]["nombre"]?></p></li>
                <li><a class="esconder-nombre" style="color:#253141" href="/verReservas">Ver mis Reservas</a></li>
                <li><a class="esconder-nombre" style=" color:#253141" onclick="cerrarSesion(<?=$_SESSION['usuario']['id']?>)">Cerrar sesion</a></li>
           
            
            </button> 
        </div>
       
        <?php else: ?>
        <button>
        <a href="login" >
            <img src="img/user-regular.svg">
        </button> </a>
    </div>
    <?php endif?>


    <div class="izquierda">
        <button id="menu-list">
          <!-- Menu-->
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
            
          </svg>
        </button>

        <button id="lupa2">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            <!-- Lupa -->
          </svg>
        </button> 
    </div>


    <form class="cont-buscador"  action="/catalogo" method="GET">
      <input id="buscador2" type="text" name="nombre" placeholder="Buscar...">
    </form>

</nav>

<div id="sidebar">
  <div class="row">
    <div class="col-8">
  <h1 class="textopadding text-align-left"> MENU </h1> </div> <div class="col-1 float-end"><span id="cerrar1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
  <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
</svg></span> </div> 
<hr>
                </div>
                
      <div>
         <div class="row">
         
       <p class="textopadding"><a href="/catalogo" style="color:black;">CATALOGO</a></p>
 <hr>
                </div>
                <div class="row">
         
         <p class="textopadding"> <a href="/sobreNosotros" style="color:black;"> SOBRE NOSOTROS </a></p>
   <hr>
      
                </div>
                <div class="row">
         
         <p class="textopadding"> CATEGORIAS </p>
         <?php foreach($categoria as $cate):?>
          <div class="row mb-1 ">
                 <div class="col-8"> <a class="dropdown-item textopadding"  href="/catalogo?catego=<?=$cate["id"]?>"><?=$cate["nombreCategoria"]?></div></a> <div class="col-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/></div>
</svg>  </div>
         
                <?php endforeach?>
         
   <hr>
                  </div>
               
               
      </div>
     
</div>   


<script>


    
      $(document).ready(function() {
    
    $('#lupa2').click(function() {
        // Cierra el sidebar si está abierto
        $("#sidebar").removeClass("active");
        
        // Alterna el buscador (abre/cierra)
        $("#buscador2").toggleClass("active");
    });

    $('#menu-list').click(function() {
        // Cierra el buscador si está abierto
        $("#buscador2").removeClass("active");
        
        // Abre el sidebar
        $("#sidebar").addClass("active");
    });

    $('#cerrar1').click(function() {
        // Cierra el sidebar
        $("#sidebar").removeClass("active");
    });

  

    
 
});

 function abrirMenu() {
      $(".submenu-logueado").toggle();
}

    function mostrarCantidadP() {
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        let cantidadCarrito = carrito.length;
        localStorage.setItem("contenidoDiv", cantidadCarrito);
        document.getElementById("carr-cantidad").innerHTML = cantidadCarrito;

    }
    window.addEventListener("load", function() {
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        let cantidadCarrito = carrito.length;
        localStorage.setItem("contenidoDiv", cantidadCarrito);
        document.getElementById("carr-cantidad").innerHTML = cantidadCarrito;
    });



</script>

