<?php
namespace app\models;
use rutex\Model;

class Producto extends Model {
    protected $table = "productos";

    //Estructura de la tabla indicando los campos obligatorios en el insert
    protected $struct = [
        "id"              => ["required" => false],  
        "nombre"          => ["required" => true ],      
        "descripcion"     => ["required" => true ],
        "precioCaja"      => ["required" => false],
        "precio"          => ["required" => true ], 
        "imagen"          => ["required" => false],    
        "categoria_id"    => ["required" => true ],
        "subcategoria_id" => ["required" => true ],
        "stock"           => ["required" => true ],
        "oferta"          => ["required" => false ],
        "cantidadCaja"    => ["required" => false ],
   ];
}