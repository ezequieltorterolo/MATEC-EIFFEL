<?php

namespace app\controllers;

use rutex\BaseController;
use app\models\Producto;
use app\models\Usuario;
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

        if (isset($_GET["catego"])) {
            $catego = $this->categorias()[$_GET["catego"]];
            if (!empty($catego)) $producto->where("categoria", "=", $catego);

        } elseif (isset($_GET["nombre"])) {
            $nombre = $_GET["nombre"];
            if (!empty($nombre)) $producto->where("nombre", "like", "%$nombre%");
        };

        $data["data"]   = $producto->getAll();
        $data["totrec"] = $producto->affected_rows();

        return $this->view("catalogo", $data);
    }

    


    //SIMULACION DE TABLA CATEGORIAS
    function categorias()
    {
        $categoria[1] = "Alimentos";
        $categoria[2] = "Limpieza";
        $categoria[3] = "Higiene";
        $categoria[4] = "Insumos de cocina";

        return $categoria;
    }



    function carrito()
    {
      

        return $this->view("carrito");
    }
}
