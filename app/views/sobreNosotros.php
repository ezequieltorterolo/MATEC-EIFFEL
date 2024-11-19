<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOBRE NOSOTROS</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style10.css" rel="stylesheet" type="text/css">
    <link href="styles/styles_general.css" rel="stylesheet" type="text/css">
    <link rel="icon"  href="../img/logito.ico">
</head>
<body> 
    

<button id="btn-arriba"  style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60 fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z"/>
</svg></button>
    <?php include "segments/header.php" ?>
    <?php include "segments/nav.php" ?>

    <div class="container mt-5">

  
    <div class="container-fluid">
        <div class="row">
            <div id="seccion-imagen1" class="col-12">
                <img class="img-fluid w-100 rounded" src="img/foto-empresa-eiffel.jpg" alt="Foto de Eiffel Importaciones">
            </div>
        </div>
    </div>


        
            <div class="seccion-titulo mt-3 grueso5" id="megatitulo">
                <h1> TU NUEVA DISTRUBIDORA DE CONFIANZA</h1>
                <hr>
            </div>
            <p id="texto">En Eiffel Importaciones, somos una distribuidora de Minas, Lavalleja con una sólida trayectoria en la venta y distribución de productos al por mayor. Nos especializamos en brindarles a las empresas una amplia variedad de productos de calidad a los mejores precios.</p>
            <div class="col d-flex justify-content-center">
           
        </div>


        <div class="row mx-2 mt-5 d-flex justify-content-center" id="columnas">
       
           
                    <div class="col-md-3 col-12 p-3" id="tarjetita">
                        <h2><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
  <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
</svg>NUESTRA EXPERIENCIA</h2>
                        <hr>
                        <p>Con varios años de experiencia, hemos evolucionado para atender a todo tipo de negocios de consumo dentro de la ciudad de manera confiable y rápida. Nos enorgullece ser el punto de conexión entre las mejores marcas y los mejores precios, brindando un surtido extenso y variado.</p>
                    </div>
                    <div class="col-md-3 col-12 p-3" id="tarjetita">
                        <h2 > <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
  <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
</svg>CATÁLOGO VARIADO</h2>
                        <hr>
                        <p >Estamos comprometidos con la expansión continua de nuestro catálogo para satisfacer las necesidades del mercado, siempre a la vanguardia de las tendencias y requerimientos de nuestros clientes.</p>
                    </div>
                    <div class="col-md-3 col-12 p-3" id="tarjetita">
                        <h2> <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
  <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
</svg>CONFIABILIDAD Y RAPIDEZ</h2>
                        <hr>
                        <p>En Eiffel Importaciones, tratamos de dar el servicio más personalizado y cómodo posible. Nuestro equipo está disponible para asesorar a nuestros clientes a través de múltiples canales de comunicación: teléfono, correo electrónico y WhatsApp. Nos esforzamos para abastecer a nuestros clientes de forma rápida y flexible, incluso en momentos de alta demanda, asegurando que sus productos lleguen a destino en tiempo y forma.</p>
                    </div>
                </div>
           
            
         
        </div>

       
        <div id="comoEncargarses" class="container mx-auto">
            <div class="seccion-titulo">
                <h1 id="comoEncargar">CÓMO ENCARGAR</h1>
                <hr>
            </div>
            <p>Para realizar una reserva será necesario que tengas una cuenta existente, que puedes crear clickeando el ícono de usuario en el menú de navegación. Luego, añade productos al carrito:</p>
            <ul>
                <li>Clickea en la foto del producto que desees.</li>
                <li>En la página del producto, selecciona la cantidad y añade al carrito. Se aplicará el precio por mayor automáticamente cuando llegues a la cantidad de la caja.</li>
                <li>Consulta el carrito y revisa el total de los productos añadidos.</li>
                <li>Cuando estés listo para reservar, completa el formulario y confirma.</li>
                <li>Recibirás una confirmación por e-mail y una notificación cuando tu pedido esté listo para la entrega.</li>
            </ul>
        </div>
</div>
 
        <script>
            $(document).ready(function() {
    // Mostrar el botón cuando el usuario haya desplazado hacia abajo
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {  // Puedes ajustar el valor según prefieras
            $('#btn-arriba').fadeIn();
        } else {
            $('#btn-arriba').fadeOut();
        }
    });

    // Hacer scroll hacia arriba cuando el botón sea clickeado
    $('#btn-arriba').click(function() {
        $('html, body').animate({scrollTop: 0}, 500);  // 500ms para el efecto de scroll
        return false;
    });
});
            </script>

    <?php include "segments/footer.php" ?>

</body>
</html>
