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
        "direccion"        => ["required" => true  ],
        "telefono"         => ["required" => true  ],
        "respuesta"        => ["required" => false ],
        "pregunta"         => ["required" => false ],

   ];
   function usuarioLoggeado() {
    return [
        "id"     => $this->current["id"],
        "nombre" => $this->current["nombre"],
        "direccion" => $this->current["direccion"],
    ];
}
function usuarioRecuperando() {
    return [
        "id"     => $this->current["id"],
    ];
}
}