<head>
    <meta charset="UTF-8" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="styles/styleAdmin.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>ADMIN</title>
</head>
<body>
    <h1>Soy la pagina home del administrador</h1>

    Usuario logueado=<?= $user ?>

<a href="/admin/gestionProductos">Gestionar Productos</a>
<a href="/admin/gestionReservas">Gestionar Reservas</a>

