

<header><img src="img/logo.jpg">

<ul class="menu" class="container-fluid">    

<div>
    <form action="/catalogo" method="GET">
       
        <input  id ="buscador" type="text" name="nombre" placeholder="Buscar..." style="width:90%;">
        <button type="submit">Buscar</button>

    </form>
    <?php if (isset($_SESSION["usuario"])): ?>
        <li><h3><?=$_SESSION["usuario"]["nombre"]?></h3>
        <ul class="submenu">
                <li onclick="cerrarSesion(<?=$_SESSION['usuario']['id']?>)"><h3>Cerrar sesion</a></li>
            </ul>
        </li>
    <?php else: ?>
    <a href="/login">Inicio sesion</a>
  
    <?php endif?>
    <a href="carrito"> <img src="img/carrito.svg" style="width:25px; height:25px;"> </a> </img>
</header>
<script>
    function cerrarSesion(id){
        document.location.href= "/logout?usuarioid="+id;
    };


   
</script>


</div>