<?php

unset($_SESSION['message'], $_SESSION['error']);

class StudentController
{

    public static function create($data){
        if($data){
            /*if($data['token'] !== $_SESSION['token']){
                $_SESSION['error'] = "Token mismatch (session token is: " . $_SESSION['token'] . ")";
                return false;
            }*/
            $user = new User();
            $r = $user->create(['board_id'=>$data['board_id'], 'name'=>$data['name']]);
            if($r){
                $_SESSION['message'] = "Student Created";
                return true;
            }else{
                $_SESSION['error'] = "Error In Student Creation Process";
                return false;
            }
        }else{
            $_SESSION['error'] = "Please Insert Student Name";
            return false;
        }
    }


}