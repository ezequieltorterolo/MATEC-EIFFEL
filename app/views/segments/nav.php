<?php
use app\models\Categoria;

  $catego    = new Categoria;
  $categoria = $catego->getall();
?>


<nav class="navegacion">
    <ul class="menu nav">
        
        <li class="nav-item grueso3">
          <a href="/">INICIO</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle grueso3" data-bs-toggle="dropdown">CATEGORIAS</a>
            <ul class="dropdown-menu">
                <?php foreach($categoria as $cate):?>
                  <li> <a class="dropdown-item"  href="/catalogo?catego=<?=$cate["id"]?>"><?=$cate["nombreCategoria"]?></a></li> <li><hr class="dropdown-divider"></li>
                <?php endforeach?>
            </ul>
        </li>
   
        <li class="nav-item grueso3"><a href="/catalogo">CATALOGO</a></li> 
           
        <li class="nav-item grueso3"><a href="/sobreNosotros"> SOBRE NOSOTROS </a></li>
   
    </ul>
           
 
    <div class="iconos" style="display:none;">
      <div class="derecha"> 
        <button>
          <!-- Carrito -->
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
          </svg>
        </button>

        <!-- Login -->
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
        </button>
    </div>


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
  <h1 class="textopadding grueso5 text-align-left"> MENU </h1> </div> <div class="col-1 float-end"><span id="cerrar1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
  <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
</svg></span> </div> 
<hr>
                </div>
                
      <div>
         <div class="row">
         
       <p class="textopadding grueso4"><a href="/catalogo">CATALOGO</a></p>
 <hr>
                </div>
                <div class="row">
         
         <p class="textopadding grueso4"> <a href="/sobreNosotros"> SOBRE NOSOTROS </a></p>
   <hr>
      
                </div>
                <div class="row">
         
         <p class="textopadding grueso4"> CATEGORIAS </p>
         <?php foreach($categoria as $cate):?>
          <div class="row mb-1 ">
                 <div class="col-9" <li> <a class="dropdown-item textopadding"  href="/catalogo?catego=<?=$cate["id"]?>"><?=$cate["nombreCategoria"]?></a></div> <div class="col-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/></div>
</svg></li> 
         </div>
                <?php endforeach?>
         
   <hr>
                  </div>
               
               
      </div>
     
</div>   


<script>

    $(document).ready(function() {
    
          $('#lupa2').click(function() {

                  $("#buscador2").css({"display": "block", "width": "100%"});       
          });


          $('#menu-list').click(function() {
                  $("#sidebar").css({"width": "50%", "display": "block" });
                
          });


          $('#cerrar1').click(function() {

$("#sidebar").css({ "width": "0%"});  
    
});
    });




</script>

