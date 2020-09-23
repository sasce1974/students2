<?php

class Model
{
    public $id;
    public $con;
    private $table;

    public function __construct()
    {
        $boot = new Boot();
        $this->con = $boot->con;
        $this->table = lcfirst(get_class($this)) . 's'; // table name as Model class name + 's'
    }

    function all(){
        $q = "SELECT * FROM $this->table";
        $query = $this->con->prepare($q);
        $query->execute(array($this->table));

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function whereId($value){
        $q = "SELECT * FROM $this->table WHERE id = ?";
        $query = $this->con->prepare($q);
        $query->execute(array($value));

        return $query->fetch(PDO::FETCH_OBJ);
    }

    function where($item, $value){
        $item = filter_var($item, FILTER_SANITIZE_STRING);
        $q = "SELECT * FROM $this->table WHERE $item = ?";
        $query = $this->con->prepare($q);
        $query->execute(array($value));

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

}