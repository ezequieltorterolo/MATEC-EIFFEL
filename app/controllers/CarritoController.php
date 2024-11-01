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

    function carrito_confirmar($data) {
         //tomar el userid de la SESSION
         $user_id = $_SESSION["usuario"]["id"] ?? 21;

        $reserva_json = json_decode($_POST["reserva"], true);


         //crear el objeto reserva cabezal
         $reserva = new Reserva;


         //CARBAR EL REGISTRO CABEZAL
         $cabezal_reserva["usuario_id"]        = $user_id;   //$_SESSION["userid"];
         $cabezal_reserva["entrega_direccion"] = $reserva_json["dirent"];
         $cabezal_reserva["entrega_fechahora"] = $reserva_json["horaent"];
         $cabezal_reserva["aclaraciones"]      = $reserva_json["aclaraciones"];
         $cabezal_reserva["estado"]            = 0;
         $reserva_id = $reserva->insert($cabezal_reserva);

         
         $reservaProductos = new ReservaProductos;
         foreach(json_decode($reserva_json["carrito"],true) as $producto) {

            $reserva_producto["reserva_id"]  = $reserva_id;
            $reserva_producto["producto_id"] = $producto["id"];
            $reserva_producto["cantidad"]    = $producto["cantidad"];
            $reserva_producto["precio"]      = $producto["precio"];
            $reservaProductos->insert($reserva_producto);

         }

        $reserva_response = "reserva registrada correctamente";


        return $reserva_response;


    }
}
