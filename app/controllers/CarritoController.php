<?php



namespace app\controllers;

use rutex\BaseController;
use app\models\Producto;
use app\models\Reserva;
use app\models\ReservaProductos;




class CarritoController extends BaseController
{

    function carrito()
    {
        return $this->view("carrito");
    }

    function prdinfo($data){
 
        $prd = new Producto ;

        return $prd->getById($data["id"]);
    }

        
        function carrito_confirmar() {
            // Obtener el user_id de la sesión o asignar un valor predeterminado
            $user_id = $_SESSION["usuario"]["id"];
        
            // Leer el cuerpo de la solicitud y decodificar el JSON
            $data = json_decode(file_get_contents('php://input'), true);
        
            // Validar que los datos se hayan recibido correctamente
            if (!$data) {
                echo json_encode(["error" => "No se recibieron datos."]);
                return;
            }
        
            // Crear el objeto reserva cabezal
            $reserva = new Reserva;
        
            // Preparar el registro cabezal
            $cabezal_reserva = [
                "usuario_id" => $user_id,
                "entrega_direccion" => $data["dirent"],
                "entrega_fechahora" => $data["horaent"],
                "aclaraciones" => $data["aclaraciones"],
                "estado" => 0,
            ];
        
            // Insertar la reserva en la base de datos
            $reserva_id = $reserva->insert($cabezal_reserva);
        
            
        


          // Procesar los productos del carrito
$reservaProductos = new ReservaProductos;


foreach ($data["carrito"] as $producto) {
    $total = 1; 
   
    $reserva_producto = [
        "totalProducto" => $total,
        "reserva_id" => $reserva_id,
        "producto_id" => $producto["id"],
        "cantidad" => $producto["cantidad"],
    ];

     $reservaProductos -> insert($reserva_producto);
    
    }
}

}
        
    

        