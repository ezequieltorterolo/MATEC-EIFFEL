<?php

namespace app\controllers;

use rutex\BaseController;
use app\models\Producto;

class HomeController extends BaseController
{

    function index($data)
    {
        $producto        = new Producto;
        $data["ofertas"] = $producto->where("oferta", "=", true)->getall();

        return $this->view("home", $data);
    }

    function producto($data)
    {
        $producto    = new Producto;
        $data["prd"] = $producto->getById($_GET["id"]);

        return $this->view("producto", $data);
    }

    function catalogo($data)
    { 

        $producto = new Producto;
        $producto->where("stock", ">", 0);

        if (isset($_GET["catego"])) {
            $catego = $_GET["catego"];
            $producto->and("categoria_id","=",$catego);
        } 
        
        if (isset($_GET["nombre"])) {
            $nombre = $_GET["nombre"];
            $producto->and("nombre", "like", "%$nombre%");
        };

        $ordenarPor = $_POST["ordenarPor"] ?? "id"  ;
        $producto->orderBy($ordenarPor);

        $data["ordenadoPor"] = $ordenarPor;
        $data["data"]        = $producto->getAll();
        $data["totrec"]      = $producto->affected_rows();

        return $this->view("catalogo", $data);
    }
    function carrito()
    {
        return $this->view("carrito");
    }

    function sobreNos() 
    {
        return $this ->view ("sobreNosotros");
    }


    //REST llamado con fetch por carrigo.js
    function prdinfo($data){
        $prd = new Producto ;
        return $prd->getById($data["id"]);
    }
}
