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

        
    function carrito_confirmar()
    { 
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            echo json_encode(["success" => false, "error" => "No se recibieron datos."]);
            return;
        }

        if (!$this->carrito_validar_stock($data["carrito"])) {
            echo json_encode(["success" => false, "error" => "Stock insuficiente para uno o más productos."]);
            return;
        }

        $reserva = new Reserva;
        $cabezal_reserva = [
            "usuario_id" => $_SESSION["usuario"]["id"],
            "entrega_direccion" => $data["dirent"],
            "entrega_fechahora" => $data["horaent"],
            "aclaraciones" => $data["aclaraciones"],
            "estado" => 0,
        ];

        $reserva_id = $reserva->insert($cabezal_reserva);

        if (!$reserva_id) {
            echo json_encode(["success" => false, "error" => "Error al registrar la reserva en la base de datos."]);
            return;
        }

        $reservaProductos = new ReservaProductos;
        $obj_producto = new Producto;

        foreach ($data["carrito"] as $producto) {
            $stock_producto = $obj_producto->getbyid($producto["id"]);

            $total ="";

            if ( $producto["cantidad"] >=  $stock_producto["cantidadCaja"])
                $precio = $stock_producto["precioCaja"] ;
            else
                $precio= $stock_producto["precio"];
            
                
            $total = $producto["cantidad"] * $precio;
      




            $reserva_producto = [

                "totalProducto" => $total,
                "reserva_id" => $reserva_id,
                "producto_id" => $producto["id"],
                "cantidad" => $producto["cantidad"],
            ];

            if (!$reservaProductos->insert($reserva_producto)) {
                echo json_encode(["success" => false, "error" => "Error al registrar el producto en la reserva."]);
                return;
            }

            $stock = $stock_producto["stock"] - $producto["cantidad"];
            $obj_producto->update($producto["id"], ["stock" => $stock]);
        }

        echo json_encode(["success" => true, "message" => "Reserva registrada correctamente."]);
    }

    private function carrito_validar_stock($carrito)
    {
        $obj_producto = new Producto;

        foreach ($carrito as $producto) {
            $stock_producto = $obj_producto->getbyid($producto["id"]);
            if ($stock_producto["stock"] < $producto["cantidad"]) return false;
        }

        return true;
    }
}