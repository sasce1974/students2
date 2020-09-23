<?php


class User extends Model
{


    public function create($data){
        $q = "INSERT INTO users (board_id, name) VALUES (?, ?)";
        $query = $this->con->prepare($q);
        return $query->execute(array($data['board_id'], $data['name']));
    }

    public function grades($id){
        $q = "SELECT * FROM grades WHERE user_id = ?";
        $query = $this->con->prepare($q);
        $query->execute(array($id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function grade($id){
        $grades = $this->grades($id);
        $g = array();
        foreach ($grades as $grade){
            $g[] = $grade['grade'];
        }
        return $g;
    }


    public function averageGrade($id){
        $g = $this->grade($id);
        if(count($g) > 0){
            return array_sum($g)/count($g);
        }
    }

    public function maxGrade($id){
        $g = $this->grade($id);
        if(count($g) > 0){
            return max($g);
        }


    }

    public function destroy($user_id){
        $q = "DELETE FROM users WHERE id = ?";
        $query = $this->con->prepare($q);
        $query->execute(array($user_id));
        if($query->rowCount() === 1){
            $q = "DELETE FROM grades WHERE user_id = ?";
            $query = $this->con->prepare($q);
            $query->execute(array($user_id));

            return $query->rowCount();
        }else{
            return false;
        }
    }


}