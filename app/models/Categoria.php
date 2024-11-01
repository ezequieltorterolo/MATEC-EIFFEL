<?php
namespace app\models;
use rutex\Model;

class Categoria extends Model {
    protected $table = "categoria";

    protected $struct = [
        "id"                    => ["required" => false],  
        "nombreCategoria"       => ["required" => true ],
   ];
}