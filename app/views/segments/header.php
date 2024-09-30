<header><img src="img/logo.jpg">
    <form action="/catalogo" method="GET">
        <input  id ="buscador" type="text" name="nombre" placeholder="Buscar...">
        <button type="submit">Buscar</button>
    </form>
    <?php if (isset($_SESSION["usuario"])): ?>
        <h3><?=$_SESSION["usuario"]["nombre"]?></h3>
    <?php else: ?>
    <a href="/login">Inicio sesion</a>
  
    <?php endif?>
    <a href="carrito"> <img src="img/carrito.svg" style="width:25px; height:25px;"> </a> </img>
</header>
