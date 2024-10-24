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
        $data["mode"]   = "editprd2";
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
        $producto = new Producto();
        $id = $_GET["prdid"];
        $producto->delete($id);
        if ($producto->success()) {
            $data["msg"] = "el producto fue eliminado con exito";
            return $this->gestionProductos($data);
        } else {
            $data["msg"] = "no se pudo eliminar el producto";
            return $this->gestionProductos($data);
        }
    }
    function añadirProducto($data)
    {
        $data["title"]  = "Añadir Producto";
        $data["mode"]   = "addprd";
        $data["action"] = "/admin/aniadirProducto";
        $data["method"] = "POST";
        return $this->view("admin/formularioProducto", $data);
    }

    function modificarProducto($data)
    {
        $data["title"]  = "Modificar Producto";
        $data["mode"]   = "editprd";
        $data["action"] = "/admin/modificarProducto";
        $data["method"] = "POST";

        $producto = new Producto();
        if (isset($_GET["prdid"])) {
            $data["prd"] = $producto->getById($_GET["prdid"]);
        }
        return $this->view("admin/formularioProducto", $data);
    }

    function validarProducto($data)
    {
        $producto = new Producto();
        $modo = $_POST['modo'];

        $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . "../../public/img/";

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

            $nombreArchivo = basename($_FILES['imagen']['name']);
            $rutaDestino = $directorioDestino . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            } else {
                $data['msg'] = "Error al subir la imagen.";
                return $this->view('admin/formularioProducto', $data);
            }
        }

        if ($modo === 'addprd') {
            $_POST['imagen'] = $nombreArchivo;
            $_POST["oferta"] = isset($_POST["oferta"]);
            $producto->insert($_POST);


            if ($producto->success()) {
                $data['msg'] = "El producto se ha ingresado con éxito.";
            } else {
                $data['msg'] = "Hubo un error al registrar el producto.";
            }
            return $this->añadirProducto($data);
        } elseif ($modo === 'editprd') {
            $id = $_POST['id'];
            $campos = [
                "nombre"        => $_POST["nombre"],
                "descripcion"   => $_POST["descripcion"],
                "precioCaja"    => $_POST["precioCaja"],
                "precio"        => $_POST["precio"],
                "categoria"     => $_POST["categoria"],
                "subcategoria"  => $_POST["subcategoria"],
                "stock"         => $_POST["stock"],
                "oferta"        => isset($_POST["oferta"]),
                "cantidadCaja"  => $_POST["cantidadCaja"],
            ];

            if (!empty($nombreArchivo)) {
                $campos['imagen'] = $nombreArchivo;
            }
            $producto->update($id, $campos);

            if ($producto->success()) {
                $data['msg'] = "El producto se ha modificado con éxito.";
                $this->redirect("/admin/gestionProductos");
            } else {
                $data['msg'] = "Hubo un error al modificar el producto.";
                return $this->view('admin/formularioProducto', $data);
            }
        } elseif ($modo == "editprd2") {
            foreach ($_POST["id"] as $id) {
                $campos = [
                    "precioCaja"    => $_POST["precioCaja"],
                    "precio"        => $_POST["precio"],
                    "stock"         => $_POST["stock"],
                    "oferta"        => isset($_POST["oferta"]),
                ];
                $producto->update($id, $campos);
            }
            if ($producto->success()) {
                $this->redirect("/admin/gestionProductos");
            } else {
                $data['msg'] = "Hubo un error al modificar el producto.";
                return $this->view('admin/formularioProducto', $data);
            }
        }
    }
    function guardarTodo($data)
    {
        $producto = new Producto();
        if (is_array($_POST["id"])) {
            foreach ($_POST["id"] as $index => $id) {
                $campos = [
                    "precioCaja" => $_POST["precioCaja"][$index],
                    "precio"     => $_POST["precio"][$index],
                    "stock"      => $_POST["stock"][$index],
                    "oferta"     => isset($_POST["oferta"][$index]),
                ];
                $producto->update($id, $campos);
            }

            if ($producto->success()) {
                $data["msg"] = "los cambios se realizaron con exito";
                return $this->gestionProductos($data);
            } else {
                $data['msg'] = "Hubo un error al modificar el producto.";
                return $this->gestionProductos($data);
            }
        } else {
            $data['msg'] = "No se recibieron productos para actualizar.";
            return $this->gestionProductos($data);
        }
    }
}
