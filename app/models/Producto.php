<?php
namespace app\models;
use rutex\Model;

class Producto extends Model {
    protected $table = "productos";

    //Estructura de la tabla indicando los campos obligatorios en el insert
    protected $struct = [
        "id"           => ["required" => false],  
        "nombre"       => ["required" => true ],      
        "descripcion"  => ["required" => true ],
        "precioCaja"  => ["required" => false],
        "precio"       => ["required" => true ], 
        "imagen"       => ["required" => true ],    
        "categoria"    => ["required" => true ],
        "subcategoria" => ["required" => true ],
        "stock"        => ["required" => true ],
        "oferta"       => ["required" => true ],
        "cantidadCaja" => ["required" => false ],
   ];
}