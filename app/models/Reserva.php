<?php
namespace app\models;
use rutex\Model;

class Reserva extends Model {
    protected $table = "reservas";

    //Estructura de la tabla indicando los campos obligatorios en el insert
    protected $struct = [
        "id"                    => ["required" => false],  
        "usuario_id"            => ["required" => true ],      
        "entrega_direccion"     => ["required" => true ],
        "entrega_fechahora"     => ["required" => true ],
        "aclaraciones"          => ["required" => false],
        "estado"                => ["required" => false ], 
   ];
}