<?php

namespace app\controllers;

use app\models\Producto;
use rutex\BaseController;

class AdminController extends BaseController
{

    function login($data)
    {
        if (isset($_SESSION["admin"])) {
            $data["user"] = $_SESSION["admin"];
            return $this->view("admin/homeAdmin", $data);
        } else {
            return $this->view("admin/formlogin", $data);
        }
    }

    function ValidarIngresoAdmin($data)
    {

        //cuando no esta logueado

        if ($_POST["pass"] == "secreto" && $_POST["name"] == "martin") {
            //mostrar pagina de dos opciones

            //Guardo en la sesion el nombre del usuario logueado
            $_SESSION["admin"] = $_POST["name"];

            //Parametros de la pagina
            $data["user"] = $_POST["name"];

            return $this->view("admin/homeAdmin", $data);
        } else
            return $this->view(htmlError("403", "Acceso denegado", ""));
    }

    function gestionProductos($data)
    {
        $producto  = new Producto;

        if (isset($_GET["nombre"])) {
            $nombre = $_GET["nombre"];
            if (!empty($nombre)) $producto->where("nombre", "like", "%$nombre%");
        };

        $data["data"]   = $producto->getAll();
        $data["totrec"] = $producto->affected_rows();

        return $this->view("admin/gestionProductos", $data);
    }

    function productoAdmin($data)
    {
        $producto    = new Producto;
        $data["prd"] = $producto->getById($_GET["id"]);


        return $this->view("admin/productoAdmin", $data);
    }

    function reservas($data)
    {
        return $this->view("admin/reservas", $data);
    }

    function eliminar($data)
    {
        return "queremos eliminar el producto " . $_GET["prdid"];
    }

    function actualizarProductos($data)
    {
        $producto = new Producto();
        $id = [$_POST['id']];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach($id as $prd){
                $prd = $producto->getById($id);
                $prd->update($id,[
                    "precio" => $_POST['precio'],
                    "precioCaja" =>  $_POST['precioCaja'],
                    "stock" => $_POST["stock"],
                ]);
                $this->redirect("admin/gestionProductos");
            }
        }
    }
    function añadirProducto($data)
    {
        $data["title"]  = "Añadir Producto";
        $data["mode"]   = "addprd";
        $data["action"] = "/admin/aniadirProducto";
        $data["method"] = "POST";
        return $this->view("admin/formularioProducto",$data);
    }
    
    function modificarProducto($data)
    {
        $data["title"]  = "Modificar Producto";
        $data["mode"]   = "editprd";
        $data["action"] = "/admin/modificarProducto";
        $data["method"] = "POST";

        $producto = new Producto();
        if(isset($_GET["prdid"])){
            $data["prd"] = $producto -> getById($_GET["prdid"]);
        }
        return $this->view("admin/formularioProducto",$data);
    }
    function validarProducto($data){
        $producto = new Producto;
        $id = $_POST["id"];
        $_POST["oferta"] = $_POST["oferta"] ? 1 : 0;
        if($_POST["modo"] == "addprd"){
            $producto->insert($_POST);
            if ($producto->success()) {
            $data["msg"] = "El producto se a ingresado con exito";
               return $this->añadirProducto($data);
            }
            else {
                $data["msg"] = "hubo un error al registrar el producto";
                return $this->añadirProducto($data);
            }


        }elseif($_POST["modo"] == "editprd"){
            $producto->update($id,[
                "nombre" => $_POST["nombre"],
                "descripcion" => $_POST["descripcion"],
                "precioCaja" => $_POST["precioCaja"],
                "precio" => $_POST["precio"],
                "imagen" =>$_POST["imagen"] ,
                "categoria" => $_POST["categoria"],
                "subcategoria" => $_POST["subcategoria"],
                "stock" => $_POST["stock"],
                "oferta" => $_POST["oferta"] ? 1 : 0,
                "cantidadCaja" => $_POST["cantidadCaja"],
            ]
        );
            if ($producto->success()) {
            $data["msg"] = "El producto se a modificado con exito";
               return $this->view("admin/modificarProducto",$data);
            }
            else {
                $data["msg"] = "hubo un error al modificar el producto";
                return $this->view("admin/modificarProducto",$data);
            }
        }
    }
}
