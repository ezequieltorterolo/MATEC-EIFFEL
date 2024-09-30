<?php
namespace app\models;
use rutex\Model;

class Usuario extends Model {
    protected $table = "usuarios";

    //Estructura de la tabla indicando los campos obligatorios en el insert
    protected $struct = [
        "idUsuarios"       => ["required" => false],  
        "nombre"           => ["required" => true ],
        "email"            => ["required" => true ],  
        "contraseña"       => ["required" => true ],      

   ];
   function usuarioLoggeado() {
    return [
        "idUsuarios"     => $this->current["idUsuarios"],
        "nombre" => $this->current["nombre"],
    ];
}
}