<?php

namespace app\controllers;

use app\models\Producto;
use app\models\Reserva;
use app\models\Categoria;
use app\models\SubCategoria;
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
            $data["catego"] = $categoria->getAll();
            if (isset($_GET["categoria"])) {
                $catego = $_GET["categoria"];
                if (!empty($catego) && $catego !== "-1") $producto->and("categoria_id", "=", $catego);
            } elseif (isset($_GET["nombre"])) {
                $nombre = $_GET["nombre"];
                if (!empty($nombre)) $producto->and("nombre", "like", "%$nombre%");
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

    function eliminarProducto($data)
    {
        if (isset($_SESSION["admin"])) {
            $producto = new Producto();
            $id = $_GET["prdid"];
            $productoData = $producto->getById($id);
            if ($productoData && !empty($productoData['imagen'])) {
                $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . '/eiffel/public/img/' . $productoData['imagen'];
                if (file_exists($rutaImagen)) {
                    if (unlink($rutaImagen)) {
                        $data['msg'] = "Imagen eliminada correctamente.";
                    } else {
                        $data['msg'] = "No se pudo eliminar la imagen.";
                    }
                }
            }
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
            $subcategoria = $this->subcategoria();
            $data["subcategoria"] = $subcategoria;
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
            $subcategoria = $this->subcategoria();
            $data["subcategoria"] = $subcategoria;
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
        $subCategorias = new SubCategoria();
        $modo = $_POST['modo'];

        $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . "../../public/img/";

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

            $nombreArchivo = basename($_FILES['imagen']['name']);
            $rutaDestino = $directorioDestino . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            } else {
                $data['msg'] = "Error al subir la imagen.";
                $this->redirect("formularioProducto", $data);
            }
        }
        if (!empty($_POST["categoria2"])) {
            $campos2 = [
                'nombreCategoria' => $_POST["categoria2"],
            ];
            $id_categoria = $categorias->insert($campos2);
            $_POST["categoria_id"] = $id_categoria;
        }
        if (!empty($_POST["subcategoria2"])) {
            $campos3 = [
                'nombreSubCategoria' => $_POST["subcategoria2"],
            ];        
            $id_subCategoria = $subCategorias->insert($campos3);
            $_POST["subcategoria_id"] = $id_subCategoria;  
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
            $this->redirect("aniadirProducto", $data);
        } elseif ($modo === 'editprd') {
            $id = $_POST['id'];
            $campos = [
                "nombre"         => $_POST["nombre"],
                "descripcion"    => $_POST["descripcion"],
                "precioCaja"     => $_POST["precioCaja"],
                "precio"         => $_POST["precio"],
                "stock"          => $_POST["stock"],
                "oferta"         => isset($_POST["oferta"]),
                "cantidadCaja"   => $_POST["cantidadCaja"],
            ];

            if (!empty($nombreArchivo)) {
                $campos['imagen'] = $nombreArchivo;
            }
            if ($_POST["categoria_id"] !== 0) {
                $campos["categoria_id"] = $_POST["categoria_id"];
            }
            if ($_POST["subcategoria_id"] !== 0) {
                $campos["subcategoria_id"] = $_POST["subcategoria_id"];
            }


            $producto->update($id, $campos);

            if ($producto->success()) {
                $data['msg'] = "El producto se ha modificado con éxito.";
                $this->redirect("gestionProductos");
            } else {
                $data['msg'] = "Hubo un error al modificar el producto.";
                $this->redirect("formularioProducto", $data);
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
                $data["msg"] = "producto modificado con exito";
                $this->redirect("gestionProductos", $data);
            } else {
                $data['msg'] = "Hubo un error al modificar el producto.";
                $this->redirect("formularioProducto", $data);
            }
        }
    }
    function guardarTodoProductos($data)
    {
        $producto = new Producto();

        // Asegúrate de que 'id' sea un array y procesa cada producto
        if (is_array($_POST["id"])) {
            foreach ($_POST["id"] as $index => $id) {
                $campos = [
                    "precioCaja" => $_POST["precioCaja"][$index],
                    "precio"     => $_POST["precio"][$index],
                    "stock"      => $_POST["stock"][$index] ?? null,
                    "oferta"     => isset($_POST["oferta"][$index]) ? 1 : 0, // Checkbox handling
                ];
                $producto->update($id, $campos);
            }

            if ($producto->success()) {
                $this->redirect("/admin/gestionProductos");
            } else {
                $data['msg'] = "Hubo un error al modificar los productos.";
                return $this->gestionProductos($data);
            }
        } else {
            $data['msg'] = "No se recibieron productos para actualizar.";
            return $this->gestionProductos($data);
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

            // Filtrado por estado
            if (isset($_GET["estado2"])) {
                $estado = $_GET["estado2"];
                if ($estado !== "-1") {
                    $reservas->and("estado", "=", $estado);
                }
            }
            if (isset($_GET["nombre"])) {
                $nombre = $_GET["nombre"];
                if (!empty($nombre)) {
                    $usuario->and("nombre", "like", "%$nombre%");
                    $id = $usuario["id"];
                    if (!empty($usuario)) {
                        $reservas->where("usuario_id", "=", $id)->getAll();
                    } else {
                        $data["msg"] = "No se encontraron usuarios con ese nombre.";
                        $this->redirect("gestionReservas", $data);
                        return;
                    }
                }
            }

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
            $this->redirect("gestionReservas", $data);
        } else {
            $data['msg'] = "Hubo un error al guardar las reservas y productos.";
            $this->redirect("gestionReservas", $data);
        }
    }

    function agregarProducto($data)
    {
        if (isset($_SESSION["admin"])) {
            $reservaprd = new ReservaProductos();
            $campos = [
                "producto_id"   => $_POST["prdSeleccionado"],
                "reserva_id"    => $_POST["reservaId"],
                "cantidad"      => $_POST["cantidadPrd"],
                "totalProducto" => 1,

            ];
            $reservaprd->insert($campos);
            if ($reservaprd->success()) {
                $data["msg"] = "producto agregado con exito";
                $this->redirect("gestionReservas", $data);
            } else {
                $data["msg"] = "hubo un error al agregar el producto,intente nuevamente";
                $this->redirect("gestionReservas", $data);
            }
        } else {
            $this->redirect("/admin");
        }
    }

    function eliminarProductoReserva($data)
    {
        if (isset($_SESSION["admin"])) {
            $reservaProductos = new ReservaProductos();
            $id = $_GET["prdid"];
            $reservaProductos->delete($id);
            if ($reservaProductos->success()) {
                $data["msg"] = "el producto fue eliminado con exito";
                $this->redirect("gestionReservas", $data);
            } else {
                $data["msg"] = "no se pudo eliminar el producto";
                $this->redirect("gestionReservas", $data);
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
                $this->redirect("gestionReservas", $data);
            } else {
                $data["msg"] = "no se pudo eliminar la reserva";
                $this->redirect("gestionReservas", $data);
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
    function subcategoria()
    {
        $subcatego = new SubCategoria();
        $subcategoria = $subcatego->getAll();
        return $subcategoria;
    }


    function gestionUsuarios()
    {
        $data["action"] = "/admin/gestionUsuarios";
        $usuarios = new Usuario();
        if (isset($_GET["nombre"])) {
            $nombre = $_GET["nombre"];
            if (!empty($nombre)) {
                $usuarios->and("nombre", "like", "%$nombre%")->select()->getFirst();
            }
        }
        $data["usuarios"] = $usuarios->getAll();
        return $this->view("admin/gestionUsuarios", $data);
    }

    function eliminarUsuario($data)
    {
        if (isset($_SESSION["admin"])) {
            $usuario = new Usuario();
            $id = $_GET["userid"];
            $usuario->delete($id);
            if ($usuario->success()) {
                $data["msg"] = "el usuario fue eliminado con exito";
                $this->redirect("gestionUsuarios", $data);
            } else {
                $data["msg"] = "no se pudo eliminar el usuario";
                $this->redirect("gestionUsuarios", $data);
            }
        } else {
            $this->redirect("/admin");
        }
    }
}
