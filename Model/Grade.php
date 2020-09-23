<?php



class Grade extends Model
{
    public function create($data){
        $q = "INSERT INTO grades (user_id, grade) VALUES (?, ?)";
        $query = $this->con->prepare($q);
        return $query->execute(array($data['user_id'], $data['grade']));
    }


    public function destroy($grade_id){
        $q = "DELETE FROM grades WHERE id = ?";
        $query = $this->con->prepare($q);
        $query->execute(array($grade_id));
        if($query->rowCount() === 1){
            return true;
        }else{
            return false;
        }
    }


    public function export($board_id)
    {
        $user = new User();
        $users = $user->where('board_id', $board_id);

        $data = array();

        for ($i = 0; $i < count($users); $i++) {
            $grades = $user->grade($users[$i]->id);
            $average = $user->averageGrade($users[$i]->id);
            $maxGrade = $user->maxGrade($users[$i]->id);
            $data[$i]['user']['id'] = $users[$i]->id;
            $data[$i]['user']['name'] = $users[$i]->name;
            $data[$i]['grades'] = $grades;
            $data[$i]['average'] = $average;

            if ($board_id === 1) {
                $data[$i]['final result'] = ($average < 7) ?
                    'Failed' : 'Passed';
            } else {
                $data[$i]['final result'] = (count($grades) > 2 &&
                    $maxGrade >= 8) ?
                    'Passed' : 'Failed';
            }

        }
        if ($board_id == 1) {
            return json_encode($data);
        } else {
            return $this->arrayToXML($data);
        }
    }


        private function arrayToXML(array $data){

            function array_to_xml( $data, &$xml_data ) {
                foreach( $data as $key => $value ) {
                    if( is_array($value) ) {
                        if( is_numeric($key) ){
                            $key = 'item'.$key;
                        }
                        $subnode = $xml_data->addChild($key);
                        array_to_xml($value, $subnode);
                    } else {
                        $xml_data->addChild("$key",htmlspecialchars("$value"));
                    }
                }
            }

            $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

            array_to_xml($data,$xml_data);

            return $xml_data->asXML();

        }
}