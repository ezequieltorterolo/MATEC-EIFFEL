<?php

namespace app\controllers;

use app\models\Categoria;
use rutex\BaseController;
use app\models\Producto;
use app\models\Reserva;
use app\models\ReservaProductos;

class HomeController extends BaseController
{

    function index($data)
    {
        $producto        = new Producto;
        $data["ofertas"] = $producto->where("oferta", "=", true)->and("stock", ">", 0)
            ->getall();

        return $this->view("home", $data);
    }

    function producto($data)
    {
        $producto    = new Producto;
        $categoria   = new Categoria;
        $data["prd"] = $producto->getById($_GET["id"]);
        $cat = $data["prd"]["categoria_id"];
        $data["cat"] = $categoria->getById($cat);

        return $this->view("producto", $data);
    }

    function catalogo($data)
    {

        $producto = new Producto;
        $producto->where("stock", ">", 0);

        if (isset($_GET["catego"])) {
            $catego = $_GET["catego"];
            $producto->and("categoria_id", "=", $catego);
        }

        if (isset($_GET["nombre"])) {
            $nombre = $_GET["nombre"];
            $producto->and("nombre", "like", "%$nombre%");
        };

        $ordenarPor = $_POST["ordenarPor"] ?? "id";
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
        return $this->view("sobreNosotros");
    }


    //REST llamado con fetch por carrigo.js
    function prdinfo($data)
    {
        $prd = new Producto;
        return $prd->getById($data["id"]);
    }
    function verReservas($data)
    {
        if (isset($_SESSION["usuario"])) {
            $reservas = new Reserva();
            $producto = new Producto();
            $reservaproducto = new ReservaProductos();
            if (isset($_GET["estado"])) {
                $estado = $_GET["estado"];
                    if($estado !== "-1"){
                    $reservas->and("estado", "=", $estado);
            }
        }
            $data["reservas"] = $reservas->and("usuario_id", "=", $_SESSION["usuario"]["id"])->orderBy("estado ASC")->getAll();
            $data["producto"] = $producto->getAll();
            $data["reservaproducto"] = $reservaproducto->getAll();
            return $this->view("verReservas", $data);
        } else {
            $this->redirect("login");
        }
    }
    function cancelarReserva($data){
        if (isset($_SESSION["usuario"])) {
            $reservas = new Reserva();
            $id = $_GET["resid"];
            $campo =[
                "estado" => 2,
            ];
            $reservas->update($id,$campo);
            if($reservas->success()){
                $data["msg"] = "su reserva fue cancelada con exito";
                $this->redirect("verReservas",$data);
            }
        } else {
            $this->redirect("login");
        }
    }
}
