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

        $reserva = json_decode($_POST["reserva"], true);

        //crear el objeto reserva cabezal
        $model_reserva = new Reserva;

        //tomar el userid de la SESSION
        $user_id = 21;

        //CARBAR EL REGISTRO CABEZAL
        $cabezal_reserva["usuario_id"]        = $user_id;   //$_SESSION["userid"];
        $cabezal_reserva["entrega_direccion"] = $reserva["dirent"];
        $cabezal_reserva["entrega_fechahora"] = $reserva["horaent"];
        $cabezal_reserva["aclaraciones"]      = $reserva["aclaraciones"];
        $cabezal_reserva["estado"]            = 0;
        $reserva_id = $model_reserva->insert($cabezal_reserva);


        foreach($reserva["carrito"] as $producto) {
            $model_reserva_productos = new ReservaProductos;

            $prd      = new Producto;
            $prdinfo  = $prd->getbyid($producto["id"]);


            $data_reserva["reserva_id"]  = $reserva_id;
            $data_reserva["producto_id"] = $producto["id"];
            $data_reserva["cantidad"]    = $producto["cantidad"];

//CALVULAR PRECIO            
            $data_reserva["precio"]      =  $producto["cantidad"] * $prdinfo["precio"];

            $model_reserva_productos->insert($data_reserva);

        }


    }
}
