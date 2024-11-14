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
        // Verificar si el usuario está logueado
        if (!isset($_SESSION["usuario"])) {
            echo json_encode(["success" => false, "error" => "Debes iniciar sesión para hacer una reserva."]);
            return;
        }

        // Obtener datos de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            echo json_encode(["success" => false, "error" => "No se recibieron datos."]);
            return;
        }

        // Validar stock de cada producto en el carrito
        $stockValido = $this->carrito_validar_stock($data["carrito"]);
        if ($stockValido !== true) {
            echo json_encode(["success" => false, "error" => "Stock insuficiente para el producto: " . $stockValido]);
            return;
        }

        // Crear el objeto reserva cabezal
        $reserva = new Reserva;
        $cabezal_reserva = [
            "usuario_id" => $_SESSION["usuario"]["id"],
            "entrega_direccion" => $data["dirent"],
            "entrega_fechahora" => $data["horaent"],
            "aclaraciones" => $data["aclaraciones"],
            "estado" => 0,
        ];

        // Insertar la reserva en la base de datos
        $reserva_id = $reserva->insert($cabezal_reserva);

        if (!$reserva_id) {
            echo json_encode(["success" => false, "error" => "Error al registrar la reserva en la base de datos."]);
            return;
        }

        // Procesar los productos del carrito
        $reservaProductos = new ReservaProductos;
        $obj_producto = new Producto;

        foreach ($data["carrito"] as $producto) {
            $stock_producto = $obj_producto->getbyid($producto["id"]);

            // Calcular el precio total para el producto
            $precio = $producto["cantidad"] >= $stock_producto["cantidadCaja"] ? $stock_producto["precioCaja"] : $stock_producto["precio"];
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

            // Actualizar stock del producto
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
            if ($stock_producto["stock"] < $producto["cantidad"] || $stock_producto["stock"] = 0 ) {
                return $producto["nombre"]; // Devuelve el ID del producto con stock insuficiente
            }
        }

        return true;
    }
}