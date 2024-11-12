<?php

namespace app\controllers;

use app\models\Producto;
use app\models\Reserva;
use app\models\Categoria;
use app\models\Usuario;
use app\models\ReservaProductos;
use rutex\BaseController;

class AdminController extends BaseController
{

    function login($data)
    {
        if (isset($_SESSION["admin"])) {
            $this->redirect("admin/homeAdmin", $data);
        } else {
            return $this->view("admin/formlogin", $data);
        }
    }

    function ValidarIngresoAdmin($data)
    {
        if ($_POST["pass"] == "secreto" && $_POST["name"] == "martin") {

            $_SESSION["admin"] = $_POST["name"];

            $data["user"] = $_POST["name"];

            $this->redirect("admin/homeAdmin", $data);
        } else
            return $this->view(htmlError("403", "Acceso denegado", ""));
    }
    function homeAdmin($data)
    {
        if (isset($_SESSION["admin"])) {
            $data["user"] = $_SESSION["admin"];
            return $this->view("admin/homeAdmin", $data);
        } else {
            return $this->view("admin/formlogin", $data);
        }
    }

    function gestionProductos($data)
    {
        if (isset($_SESSION["admin"])) {
            $data["action"] = "/admin/gestionProductos";
            $data["mode"]   = "editprd2";
            $categoria = new Categoria();
            $producto  = new Producto;
            if (isset($_GET["categoria"])) {
                $categoria = $_GET["categoria"];
                if (!empty($categoria)) $categoria->where("id", "=", $categoria);
            } elseif (isset($_GET["nombre"])) {
                $nombre = $_GET["nombre"];
                if (!empty($nombre)) $producto->where("nombre", "like", "%$nombre%");
            };

            $data["data"]   = $producto->getAll();
            $data["totrec"] = $producto->affected_rows();

            return $this->view("admin/gestionProductos", $data);
        } else {
            $this->redirect("/admin");
        }
    }

    function productoAdmin($data)
    {
        if (isset($_SESSION["admin"])) {
            $producto    = new Producto;
            $data["prd"] = $producto->getById($_GET["id"]);


            return $this->view("admin/productoAdmin", $data);
        } else {
            $this->redirect("/admin");
        }
    }

    function eliminar($data)
    {
        if (isset($_SESSION["admin"])) {
            $producto = new Producto();
            $id = $_GET["prdid"];
            $producto->delete($id);
            if ($producto->success()) {
                $data["msg"] = "el producto fue eliminado con exito";
                $this->redirect("gestionProductos", $data);
            } else {
                $data["msg"] = "no se pudo eliminar el producto";
                $this->redirect("gestionProductos", $data);
            }
        } else {
            $this->redirect("/admin");
        }
    }
    function añadirProducto($data)
    {
        if (isset($_SESSION["admin"])) {
            $data["title"]  = "Añadir Producto";
            $data["mode"]   = "addprd";
            $data["action"] = "/admin/aniadirProducto";
            $data["method"] = "POST";
            $categoria = $this->categoria();
            $data["categoria"] = $categoria;
            return $this->view("admin/formularioProducto", $data);
        } else {
            $this->redirect("/admin");
        }
    }

    function modificarProducto($data)
    {
        if (isset($_SESSION["admin"])) {
            $data["title"]  = "Modificar Producto";
            $data["mode"]   = "editprd";
            $data["action"] = "/admin/modificarProducto";
            $data["method"] = "POST";
            $producto = new Producto();
            $categoria = $this->categoria();
            $data["categoria"] = $categoria;
            if (isset($_GET["prdid"])) {
                $data["prd"] = $producto->getById($_GET["prdid"]);
            }
            return $this->view("admin/formularioProducto", $data);
        } else {
            $this->redirect("/admin");
        }
    }

    function validarProducto($data)
    {
        $producto = new Producto();
        $categorias = new Categoria();
        $modo = $_POST['modo'];

        $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . "../../public/img/";

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

            $nombreArchivo = basename($_FILES['imagen']['name']);
            $rutaDestino = $directorioDestino . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            } else {
                $data['msg'] = "Error al subir la imagen.";
                return $this->view("admin/formularioProducto", $data);
            }
        }
        if (!empty($_POST["categoria2"])) {
            $campos2 = [
                'nombreCategoria' => $_POST["categoria2"],
            ];
            $id_categoria = $categorias->insert($campos2);
            $_POST["categoria_id"] = $id_categoria;
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
            $this->redirect("admin/añadirProducto", $data);
        } elseif ($modo === 'editprd') {
            $id = $_POST['id'];
            $campos = [
                "nombre"        => $_POST["nombre"],
                "descripcion"   => $_POST["descripcion"],
                "precioCaja"    => $_POST["precioCaja"],
                "precio"        => $_POST["precio"],
                "categoria_id"     => $_POST["categoria_id"],
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
                $this->redirect("admin/formularioProducto", $data);
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
                $this->redirect("admin/formularioProducto", $data);
            }
        }
    }
    function guardarTodoProductos($data)
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
                $this->redirect("admin/gestionProductos", $data);
            } else {
                $data['msg'] = "Hubo un error al modificar el producto.";
                $this->redirect("admin/gestionProductos", $data);
            }
        } else {
            $data['msg'] = "No se recibieron productos para actualizar.";
            $this->redirect("admin/gestionProductos", $data);
        }
    }
    function gestionReservas($data)
    {
        if (isset($_SESSION["admin"])) {
            $data["action"] = "/admin/gestionReservas";
            $reservas = new Reserva();
            $producto = new Producto();
            $reservaproducto = new ReservaProductos();
            $usuario = new Usuario();
            if (isset($_GET["nombre"])) {
                $nombre = $_GET["nombre"];
                if (!empty($nombre)) $usuario->where("nombre", "like", "%$nombre%");
            };
            $data["reservas"] = $reservas->getAll();
            $data["producto"] = $producto->getAll();
            $data["reservaproducto"] = $reservaproducto->getAll();
            $data["usuario"] = $usuario->getAll();
            return $this->view("admin/gestionReservas", $data);
        } else {
            $this->redirect("/admin");
        }
    }
    function guardarTodoReservas($data)
    {
        $reserva = new Reserva();
        $reservaProductos = new ReservaProductos();
        if (is_array($_POST["id"])) {
            foreach ($_POST["id"] as $index => $id) {
                $campos = [
                    "estado"                => $_POST["estado"][$index],
                    "entrega_direccion"     => $_POST["direccion"][$index],
                    "entrega_fechahora"     => $_POST["fecha"][$index],
                    "aclaraciones"          => $_POST["aclaraciones"][$index],
                ];
                $reserva->update($id, $campos);
                if (!empty($_POST["idPrd"])) {
                    if (is_array($_POST["idPrd"])) {
                        foreach ($_POST["idPrd"] as $index2 => $idPrd) {
                            $camposProducto = [
                                "cantidad"    => $_POST["cantidad"][$index2],
                            ];
                            $reservaProductos->update($idPrd, $camposProducto);
                        }
                    }
                }
            }
        }
        if ($reserva->success() || $reservaProductos->success()) {
            $data["msg"] = "Los cambios se realizaron con éxito";
            $this->redirect("gestionReservas",$data);
        } else {
            $data['msg'] = "Hubo un error al guardar las reservas y productos.";
            $this->redirect("gestionReservas",$data);
        }
    }

    function agregarProducto($data)
    {
        if (isset($_SESSION["admin"])) {
            $reserva = new Reserva();
            $id = $_GET["resid"];
            $reserva = $reserva->where("id", "=", $id);
        } else {
            $this->redirect("/admin");
        }
    }

    function eliminarProducto($data)
    {
        if (isset($_SESSION["admin"])) {
            $reservaProductos = new ReservaProductos();
            $id = $_GET["prdid"];
            $reservaProductos->delete($id);
            if ($reservaProductos->success()) {
                $data["msg"] = "el producto fue eliminado con exito";
                $this->redirect("gestionReservas",$data);
            } else {
                $data["msg"] = "no se pudo eliminar el producto";
                $this->redirect("gestionReservas",$data);
            }
        } else {
            $this->redirect("/admin");
        }
    }
    function eliminarReserva($data)
    {
        if (isset($_SESSION["admin"])) {
            $reserva = new Reserva();
            $id = $_GET["resid"];
            $reserva->delete($id);
            if ($reserva->success()) {
                $data["msg"] = "la reserva fue eliminada con exito";
                $this->redirect("gestionReservas",$data);
            } else {
                $data["msg"] = "no se pudo eliminar la reserva";
                $this->redirect("gestionReservas",$data);
            }
        } else {
            $this->redirect("/admin");
        }
    }

    function categoria()
    {
        $catego = new Categoria;
        $categoria = $catego->getAll();
        return $categoria;
    }
}
