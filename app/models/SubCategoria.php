<?php
namespace app\models;
use rutex\Model;

class SubCategoria extends Model {
    protected $table = "sub_categoria";

    protected $struct = [
        "id"                    => ["required" => false],  
        "nombreSubCategoria"    => ["required" => true ],
   ];
}