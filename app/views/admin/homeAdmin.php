<head>
    <meta charset="UTF-8" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="../styles/styleAdmin.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>ADMIN</title>
</head>
<body>
    <div id="cont-admin">
        <div id="cont-user">
            <h1>ADMINISTRADOR DE EIFFEL</h1>
            <p>Bienvenido, <b><?= $user ?></b></p>
            <hr>
        </div>
        <div class="boton-admin-opciones"><a href="/admin/gestionProductos">Gestionar Productos</a></div>
        <div class="boton-admin-opciones"><a href="/admin/gestionReservas">Gestionar Reservas</a></div>
        <div class="boton-admin-opciones"><a href="/admin/gestionUsuarios">Ver Usuarios</a></div>
        <img src="../img/logo.jpg">
    </div>

