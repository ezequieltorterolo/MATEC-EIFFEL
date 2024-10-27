<?php
echo "soy ordenar";
exit;
//header('Content-Type: application/json');
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = "SELECT * FROM productos WHERE nombre != ''";

    // Filtrar según la opción seleccionada por el usuario
    if (isset($_POST['orden'])) {
        $orden = $_POST['orden'];
        
        if ($orden == 'a-z') {
            $query .= " ORDER BY nombre ASC";
        } elseif ($orden == 'z-a') {
            $query .= " ORDER BY nombre DESC";
        }
    }
    $result = $conexion->query($query);
    
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacenar los datos
        $productos = [];

        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        // Enviar los resultados en formato JSON
        header('Content-Type: application/json');
        echo json_encode($productos);
    } else {
        // Si no hay resultados, devolver un JSON vacío
        header('Content-Type: application/json');
        echo json_encode([]);
    }

    $conexion->close();
}
?>
