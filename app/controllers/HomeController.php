<?php

namespace app\controllers;

use app\models\Categoria;
use rutex\BaseController;
use app\models\Producto;

use PharData;

class HomeController extends BaseController
{

    function index($data)
    {
        $producto = new Producto;

        $ofertas = $producto->where("oferta", "=", true)
                            ->select()
                            ->getCursor();

        $data["ofertas"] = $ofertas;

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

        $producto  = new Producto;
        $categorias = new Categoria;

        if (isset($_GET["catego"])) {
            $catego = $categorias->where("id","=",$_GET["catego"])->select()->getFirst();
            if (!empty($catego)) $producto->where("categoria_id","=",$catego["id"])->select()->getAll();;

        } elseif (isset($_GET["nombre"])) {
            $nombre = $_GET["nombre"];
            if (!empty($nombre)) $producto->where("nombre", "like", "%$nombre%");
        };

        $ordenarPor = $_POST["ordenarPor"] ?? "id"  ;
        $producto->orderBy($ordenarPor);

        $data["ordenadoPor"] = $ordenarPor;
        $data["data"]   = $producto->where("stock", ">",0)->getAll();
        $data["totrec"] = $producto->affected_rows();

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

    function prdinfo($data){
 
        $prd = new Producto ;

        return $prd->getById($data["id"]);
    }
}
