<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>
    <style>
        /* Estilos generales */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        /* Estilos del formulario */
        form {
            background-color: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fafafa;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Estilos responsivos */
        @media (max-width: 480px) {
            form {
                padding: 20px;
            }

            h2 {
                font-size: 22px;
            }

            input[type="text"],
            input[type="password"] {
                padding: 10px;
                font-size: 14px;
            }

            button {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<form method="POST" action="ValidarIngreso">
    <h2>Iniciar Sesión</h2>
    <input type="text" name="name" placeholder="Ingrese su nombre" required>
    <input type="password" name="pass" placeholder="Ingrese su contraseña" required>
    <button type="submit">Login</button>
</form>

</body>
</html>
