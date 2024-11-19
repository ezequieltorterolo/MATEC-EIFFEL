<?php
namespace app\models;
use rutex\Model;

class Usuario extends Model {
    protected $table = "usuarios";

    //Estructura de la tabla indicando los campos obligatorios en el insert
    protected $struct = [
        "id"               => ["required" => false ],  
        "nombre"           => ["required" => true  ],
        "email"            => ["required" => true  ],  
        "contraseña"       => ["required" => true  ],
        "direccion"        => ["required" => false ],
        "telefono"         => ["required" => true  ],          

   ];
   function usuarioLoggeado() {
    return [
        "id"     => $this->current["id"],
        "nombre" => $this->current["nombre"],
        "direccion" => $this->current["direccion"],
    ];
}
}