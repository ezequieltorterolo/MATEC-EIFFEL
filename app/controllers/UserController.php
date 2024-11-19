<?php

namespace app\controllers;

use rutex\BaseController;
use app\models\Usuario;

class UserController extends BaseController
{

    function login($data)
    {
        $data["title"]  = "Login";
        $data["mode"]   = "login";
        $data["action"] = "/login";
        $data["method"] = "POST";
        return $this->view("formulario", $data);
    }

    function validaringreso($data)
    {

        $usuario = new Usuario;
        $datosusuario = $usuario->where("email", "=", $_POST["email"])->select()->getFirst();

        if ($usuario->affected_rows() == 0) {
            $data["msg"] = "Usuario no registrado. Ingrese sus datos";
            return $this->login($data);
        } elseif (password_verify($_POST["contraseña"], $datosusuario["contraseña"])) {
            $_SESSION["usuario"] = $usuario->usuarioLoggeado();
            $this->redirect("/");
        } else {
            $data["msg"] = "Contraseña incorrecta";
            return $this->login($data);
        }
    }
    function registro($data)
    {
        $data["title"]  = "Nuevo Usuario";
        $data["mode"]   = "registro";
        $data["action"] = "/validarregistro";
        $data["method"] = "POST";
        return $this->view("formulario", $data);
    }

    function validarRegistro($data)
    {
        $usuario = new Usuario;
        $data["nombre"] = $_POST["nombre"];
        $data["email"] = $_POST["email"];

        $email = $usuario->where("email", "=", $_POST["email"])->select()->getFirst();
        if (!empty($email)) {
            $data["msg"] = "ya hay una cuenta con ese email";
            return $this->registro($data);
        }
        $_POST["contraseña"] = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
        $usuario->insert($_POST);

        if ($usuario->success()) {
            $this->redirect("login");
        } else {
            $data["msg"] = "hubo un error al registrar el usuario";
            return $this->registro($data);
        }
    }
    function logout($data)
    {
        $usuario = $_SESSION["usuario"];
        $idUsuario = $_GET["usuarioid"];
        if ($usuario["id"] == $idUsuario) {
            unset($_SESSION["usuario"]);
            $this->redirect("/");
        } else {
            return "error";
        }
    }
    function recuperarContraseñaCorreo($data)
    {
        $data["title"]  = "Ingrese su Correo";
        $data["mode"]   = "email";
        $data["action"] = "/recuperarContraseniaCorreo";
        $data["method"] = "POST";
        return $this->view("recuperarContraseña", $data);
    }
    function recuperarContraseñaPregunta($data)
    {
        $data["title"]  = "Ingrese su Correo";
        $data["mode"]   = "pregunta";
        $data["action"] = "/recuperarContraseniaPregunta";
        $data["method"] = "POST";
        $usuario = new Usuario();
        $user = $usuario->getById($_SESSION["user"]["id"]);
        $data["usuario"] = $user;
        return $this->view("recuperarContraseña", $data);
    }


    function nuevaContraseña($data)
    {
        $data["title"]  = "Ingrese su Correo";
        $data["mode"]   = "nueva contraseña";
        $data["action"] = "/nuevaContrasenia";
        $data["method"] = "POST";
        return $this->view("recuperarContraseña",$data);
    }
    function validarPasosdeRecuperacion($data)
    {
        $mode = $_POST["modo"];
        $usuario = new Usuario();
        if ($mode == "email") {
            $email = $_POST["email"];
            $user = $usuario->and("email", "=", $email)->select()->getFirst();
            if (!empty($user)) {
                $_SESSION["user"] = $usuario->usuarioLoggeado();
                return $this->redirect("recuperarContraseniaPregunta");
            } else {
                $data["msg"] = "email incorrecto o no registrado";
                return $this->redirect("recuperarContraseniaCorreo");
            }
        }
        if ($mode == "pregunta") {
            $respuesta = $_POST["respuesta"];
            $user = $usuario->getById($_SESSION["user"]["id"]);
            if ($respuesta == $user["respuesta"]) {
                return $this->redirect("nuevaContrasenia");
            } else {
                return $this->redirect("recuperarContraseniaPregunta");
            }
        }
        if ($mode == "nueva contraseña") {
            if ($_POST["contraseña"] == $_POST["repass"]) {
                $_POST["contraseña"] = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
                $campos = [
                    "contraseña" => $_POST["contraseña"],
                ];
                $usuario->update($_SESSION["user"]["id"], $campos);
                if ($usuario->success()) {
                    unset($_SESSION["user"]);
                    return $this->redirect("login");
                }else{
                    $data["msg"] = "no se pudo cambiar la contraseña";
                    return $this->redirect("nuevaContrasenia");
                    echo $data["msg"];
                }
            }else{
                $data["msg"] = "las contraseñas no son iguales";
                return $this->redirect("nuevaContrasenia");
            }
        }
    }
}
