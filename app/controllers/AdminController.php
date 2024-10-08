<?php

namespace app\controllers;
use app\models\Producto;
use rutex\BaseController;

class AdminController extends BaseController
{

    function login($data) {
        if (isset($_SESSION["admin"])) {
            $data["user"] = $_SESSION["admin"];
            return $this->view("admin/homeAdmin", $data);
        }
        else {
            return $this->view("admin/formlogin", $data); 
        }
    }

    function ValidarIngresoAdmin($data) {

        //cuando no esta logueado

        if ($_POST["pass"]=="secreto" && $_POST["name"]=="martin") {
            //mostrar pagina de dos opciones

            //Guardo en la sesion el nombre del usuario logueado
            $_SESSION["admin"] = $_POST["name"];

            //Parametros de la pagina
            $data["user"] = $_POST["name"];

            return $this->view("admin/homeAdmin", $data);
        }

        else 
           return $this->view(htmlError("403", "Acceso denegado", ""));

        }

    function gestionProductos($data) {
            $producto  = new Producto;
    
           if (isset($_GET["nombre"])) {
                $nombre = $_GET["nombre"];
                if (!empty($nombre)) $producto->where("nombre", "like", "%$nombre%");
            };
    
            $data["data"]   = $producto->getAll();
            $data["totrec"] = $producto->affected_rows();
    
        return $this->view("admin/gestionProductos", $data);
    }

        function productoAdmin($data){
            $producto    = new Producto;
            $data["prd"] = $producto->getById($_GET["id"]);


            return $this->view("admin/productoAdmin", $data);}

        

        
    function reservas($data) {
        return $this->view("admin/reservas", $data);}

    function delete($data){
        return "queremos eliminar el producto ".$_GET["prdid"];

        }
    
    }