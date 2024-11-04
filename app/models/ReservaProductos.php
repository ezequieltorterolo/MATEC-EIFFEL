<?php
namespace app\models;
use rutex\Model;

class ReservaProductos extends Model {
    protected $table = "reservas_productos";

    //Estructura de la tabla indicando los campos obligatorios en el insert
    protected $struct = [
        "id"           => ["required" => false],  
        "reserva_id"   => ["required" => true ],      
        "producto_id"  => ["required" => true ],
        "cantidad"     => ["required" => true ],
        "totalProducto"       => ["required" => true ],
       
   ];
}