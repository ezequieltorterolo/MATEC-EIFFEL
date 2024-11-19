<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>
    <link href="styles/formlogin.css" rel="stylesheet" type="text/css">
</head>
<body>
    <img src="img/logito.png" alt="Logo">
    <form method="POST" action="ValidarIngreso">
        <h2>Iniciar Sesión</h2>
        <input type="text" name="name" placeholder="Ingrese su nombre" required>
        <input type="password" name="pass" placeholder="Ingrese su contraseña" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
