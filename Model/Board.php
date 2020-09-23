<?php


class Board extends Model
{


    public function users($id){
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $q = "SELECT * FROM users WHERE board_id = ?";

        $query = $this->con->prepare($q);

        $query->execute(array($id));

        return $query->fetchAll(PDO::FETCH_OBJ);
    }


}