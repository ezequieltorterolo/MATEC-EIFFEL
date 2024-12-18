<?php
namespace rutex;

use mysqli;
use Exception;

const MODEL_VERSION = "2.7.2";

class Model {

    protected $dbconn;
    protected $cursor;

    protected $table, $struct=[], $sqlVerbose;

    private $result, $record;

    public $current;

    //variables usadas para armar la condicion del Where
    protected $condition=[], $orCondition=[], $orderBy="";

    static function version() {return MODEL_VERSION;}

    public function __construct($datastore="default") {
        $this->connect($datastore);
    }

    private function connect($datastore) {
        if (is_null($this->dbconn)) {
            $dbcfg = self::getDatastore($datastore);
            try {

                $this->dbconn = new MySqlI($dbcfg["DB_HOST"], 
                                           $dbcfg["DB_USERNAME"],
                                           $dbcfg["DB_PASSWORD"], 
                                           $dbcfg["DB_DATABASE"], 
                                           $dbcfg["DB_PORT"]);

                $this->dbconn->autocommit($dbcfg["DB_AUTOCOMMIT"]);

                //FORZAR EL USO DE UTF8
                $this->dbconn->set_charset("utf8mb4");
                // $this->dbconn->set_charset("utf8");

                $this->sqlVerbose = $dbcfg["SQL_VERBOSE"];

            } catch(Exception $e) {
                //Mostrar mensaje en pantalla (por si están deshabilitados los warnings en php.ihi)
                die("<h3>Error 500 - Falló la conexión al datastore $datastore</h3>");
            }
        }
    }

    function commit() {
        return $this->dbconn->commit();
    }

    function rollBack() {
        return $this->dbconn->rollBack();
    }

    //OBSERVABILIDAD
    function viewSelectCmd($fields="*", $page=0, $rows=0) {
        return $this->makeSelectCmd($fields, $page, $rows);
    }

    private function setResult($success, $content) {
        $this->result = ["success"=>$success, "content"=>$content];
    }

    function success() {
        return $this->result["success"];
    }

    function content() {
        return $this->result["content"];
    }

    function RequiredFields_Verify($data)  {
        $this->record   = [];
        $requiredFields = [];

        foreach($this->struct as $fieldName => $def) {
            if (isset($data[$fieldName]) && $data[$fieldName]) $this->record[$fieldName] = $data[$fieldName];
            else if ($def["required"]) $requiredFields[] = $fieldName;
        }

        $verified = empty($requiredFields);

        if ($verified) $this->setResult(true , "Todos los campos obligatorios están cargados");
        else           $this->setResult(false, "Faltan datos obligatorios: " . implode(", ", $requiredFields));

        return $verified;
    }


    function query(string $sqlcmd) {
        $this->cursor = $this->dbconn->query($sqlcmd);
        return $this;
    }

    function makeWhereCondition() {
        if (count($this->orCondition) > 0) {
            $this->condition[] = $this->orCondition;
            $this->orCondition = [];
        }

        $strcond = "";
        $and     = "";
        foreach($this->condition as $orcollection) {
            $or = "";

            $ORCondition = "";
            $ORCount     = 0;
            foreach($orcollection as $cnd) {
                $ORCount++;

                $value = $this->dbconn->real_escape_string($cnd[2]);
                $ORCondition .= $or . "$cnd[0] $cnd[1] '$value'";

                $or= " or ";
            }

            if ($ORCount>1) $strcond .= $and . "($ORCondition)";
            else            $strcond .= $and .   $ORCondition;

            $and = " and ";
        }
 
        return $strcond;
    }

    private function makeSelectCmd($fields="*", $page=0, $rows=0) {
        $whereCondition = $this->makeWhereCondition();

        if (empty($fields)) $fields = "*";
        else if (is_array($fields)) $fields = implode(",", $fields);

        if (empty($this->orderBy)) $orderBy = "";
        else $orderBy = "order by {$this->orderBy}";

        if ($page > 0 && $rows > 0) $limit = "limit " . (($page-1)*$rows) . "," .  $rows;
        else $limit = "";

        if (empty($whereCondition)) $sqlcmd= "select {$fields} from {$this->table}  {$orderBy} {$limit}";
        else $sqlcmd= "select {$fields} from {$this->table} where {$whereCondition} {$orderBy} {$limit}";

        return $sqlcmd;
    }


    function affected_rows() {
        return $this->dbconn->affected_rows;
    }


    function getFirst() {
        $this->current = $this->cursor->fetch_assoc();
        return $this->current;
    }

    function getCursor() {
        return $this->cursor->fetch_all(MYSQLI_ASSOC);
    }

    function getById($id) {
        $id = $this->dbconn->real_escape_string($id);
        return $this->query("select * from {$this->table} where id={$id}")->getFirst();
    }

    function getAll($fields="*") {
        return $this->select($fields)->getcursor();
    }

    //Armado de condicion de búsqueda
    function whereEQ(string $field, string $value) {
        return $this->where($field, "=", $value);
    }

    // function addCondition($field, string $op=null, string $value=null) {
    //     if ($value)         $this->orCondition[] = [$field, $op, $value];
    //     elseif ($op)        $this->orCondition[] = [$field, "=", $value];
    //     elseif (is_array($field)) {
    //         if (is_array($field[0])) {
    //             foreach($field as $item) {
    //                 $this->condition[] = [$item];
    //             }
    //         }
    //         else {
    //             $this->condition[] = [[$field[0], $field[1], $field[2]]];
    //         }
    //     }
    // }

    function where(string $field, string $op, string $value) {
        $this->condition   = [];
        $this->orCondition = [[$field, $op, $value]];
        $this->orderBy     = "";
        
        return $this;
    }

    function or (string $field, string $op, string $value) {
        $this->orCondition[] = [$field, $op, $value];
        return $this;
    }

    function and (string $field, string $op, string $value) {
        if (count($this->orCondition) > 0) {
            $this->condition[] = $this->orCondition;
            $this->orCondition = [];
        }

        $this->orCondition[] = [$field, $op, $value];;
        return $this;
    }

    function orderBy(string $orderBy) {
        $this->orderBy = $orderBy;
        return $this;
    }
    
    function select($fields="*", $page=0, $rows=0) {
        $sqlcmd = $this->makeSelectCmd($fields, $page, $rows);
        return $this->query($sqlcmd);
    }

    function totPages($rows=0) {
        $whereCondition = $this->makeWhereCondition();
        if (empty($whereCondition)) $sqlcmd= "select count(*) as reccount from {$this->table}";
        else $sqlcmd= "select count(*) as reccount from {$this->table} where {$whereCondition}";

        $this->query($sqlcmd);
        $reccount = $this->cursor->fetch_assoc()["reccount"];
        return ceil($reccount / $rows);
    }

    function getPage($page=0, $rows=16) {
        $url  = "/" . trim(strtolower(preg_replace("#\?(.+)#", "", $_SERVER["REQUEST_URI"])), "/") . "?page=";

        $totPages = $this->totPages($rows);
        $page     = min(max($page, 1), $totPages);

        $this->select("*", $page, $rows);

        return [
            "firstPage_url" => $url . "1",
            "prevPage_url"  => ($page>1) ? $url . $page - 1 : null,
            "nextPage_url"  => ($page < $totPages) ? $url . $page + 1 : null,
            "lastPage_url"  => $url . $totPages,
            "lastPage"      => $totPages,
            "currentPage"   => $page,
            "data"          => $this->getCursor(),
        ];
    }

    function paginate($rows=16) {
        $page = $_GET["page"] ?? 1;
        return $this->getPage($page, $rows);
    }


     function insert(array $data) {
        //verificar que los campos a insertar estén en la estructura
        if (!$this->RequiredFields_Verify($data)) {
            if ($this->sqlVerbose) throw new Exception("ERROR on sql insert => {$this->content()}");
            return 0;
        }

        $sqlcmd= "insert into {$this->table} (" . implode(",", array_keys($this->record)) . ") values (" . trim(str_repeat("?,", count($this->record)), ",") . ")";

        try {
            $stmt= $this->dbconn->prepare($sqlcmd);
            $stmt->execute(array_values($this->record));

            return $this->dbconn->insert_id;

        } catch (Exception $e) {
            if ($this->sqlVerbose) throw new Exception("ERROR on sql insert => {$e->getMessage()}");
            $this->setResult(false, $e->getMessage());
            return 0;
        }
    }

    function update(int $id, array $replacements) {
        $id     = $this->dbconn->real_escape_string($id);
        $fields = [];
        $values = [];

        //verificar que los campos a reemplazar estén en la estructura
        foreach($this->struct as $fieldName => $required) {
            if (isset($replacements[$fieldName])) {
                $fields[] = $fieldName;
                $values[] = $replacements[$fieldName];
            }
        }

        if (empty($fields)) {
            $this->setResult(false, "No hay campos para reemplazar");
            return false;
        }

        $sqlcmd = "update {$this->table} set " . implode('=?,', $fields) . "=? where id=$id";

        try {
            $stmt= $this->dbconn->prepare($sqlcmd);
            $stmt->execute($values);

            //recupera el registro recien actualizado
            $this->getById($id);
            $this->setResult(true, $this->current);
            return true;

        } catch (Exception $e) {
            if ($this->sqlVerbose) throw new Exception("ERROR on sql update => {$e->getMessage()}");
            $this->setResult(false, $e->getMessage());
            return false;
        }
    }

    function delete(int $id) {
        $id= $this->dbconn->real_escape_string($id);
        $this->query("delete from {$this->table} where id=$id");

        $affected_rows = $this->affected_rows();

        if ($affected_rows>0) $this->setResult(true, "$affected_rows Registros Eliminados OK.");
        else $this->setResult(false, "NO se eliminaron registros");

        return ($this->success());
    }

    static function getDatastore($datastore) {
        if  (is_readable("../app/models/datastores/$datastore.php")) return include "../app/models/datastores/$datastore.php";
        elseif ($datastore=="default") return [
                                                  "DB_HOST"       => getenv("DB_HOST"),
                                                  "DB_PORT"       => (int) getenv("DB_PORT"),
                                                  "DB_DATABASE"   => getenv("DB_DATABASE"),
                                                  "DB_USERNAME"   => getenv("DB_USERNAME"),
                                                  "DB_PASSWORD"   => getenv("DB_PASSWORD"),
                                                  "DB_AUTOCOMMIT" => getenv("DB_AUTOCOMMIT"),
                                                  "SQL_VERBOSE"   => getenv("SQL_VERBOSE"),
                                              ];
        else die("<h3>Datastore no encontrado $datastore");
    }

}