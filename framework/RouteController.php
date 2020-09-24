<?php

unset($_SESSION['message'], $_SESSION['error']);
require 'StudentController.php';


function checkToken($token){
    if($token !== $_SESSION['token']){
        print $token . "<hr>";
        print $_SESSION['token'];
        exit(419);
    }
}

//Base route
Router::add('/', function (){
global $include;
$include = '../includes/main.php';
includeWithVar($include, array());
});

//Show board route
Router::add('/board/([0-9]*)',function($id){
global $include, $board, $users;
$include = '../includes/board.php';
$board = new Board();
$board = $board->whereId($id);
$user = new User();
$users = $user->where('board_id', $board->id);
$token = $_SESSION['token'];
includeWithVar($include, compact('board', 'users', 'token'));
});

//Show Student route
Router::add('/board/([0-9]*)/student/([0-9]*)', function ($board_id, $student_id){
    global $board, $student, $include;
    $board = new Board();
    $board = $board->whereId($board_id);
    if($board) {
        $user = new User();
        $student = $user->whereId($student_id);
        $include = '../includes/users.php';
        includeWithVar($include, compact('board', 'student'));
    }
});

// Create Student

Router::add('/board/([0-9]*)/student/store', function ($id){

    if(isset($_POST['name']) && trim($_POST['name']) !== "") {
        $name = filter_input(INPUT_POST, 'name',
            FILTER_SANITIZE_STRING);
        $data = array();
        if (!in_array($id, array(1, 2))) $id = 1;
        $data['board_id'] = $id;
        $data['name'] = $name;

        StudentController::create($data);
    }
    header("Location:" . $_SERVER['HTTP_REFERER']);

}, 'post');


// Create Grade
Router::add('/student/([0-9]*)/grade/store', function ($student_id){
$g = new Grade();
$user = new User();
if(isset($_POST['grade']) && trim($_POST['grade']) !== ""){
$grade = filter_input(INPUT_POST, 'grade',
FILTER_SANITIZE_NUMBER_INT);

    //Check if grade is between 1 and 10
    if($grade < 1 || $grade > 10){
        $_SESSION['error'] = "Grade value must be between 1 and 10";
        header("Location:" . $_SERVER['HTTP_REFERER']);
        exit();
    }

$data = array();
$data['user_id'] = $student_id;
$data['grade'] = $grade;

//Check if there are 4 grades for this user
if(count($user->grade($student_id)) > 3){
    $_SESSION['error'] = "Maximum 4 grades allowed per student";
    header("Location:" . $_SERVER['HTTP_REFERER']);
    exit();
}

$r = $g->create($data);
if($r){
$_SESSION['message'] = "Grade Inserted";
}else{
$_SESSION['error'] = "Error In Grade Creation Process";
}
}else{
$_SESSION['error'] = "Please Insert Grade";
}
header("Location:" . $_SERVER['HTTP_REFERER']);
}, 'post');

//Delete student
Router::add('/board/([0-9]*)/student/([0-9]*)/destroy', function ($board_id, $student_id){
$user = new User();
$r = $user->destroy($student_id);
if($r !== false){

$_SESSION['message'] = "User with $r grades deleted";

}else{
$_SESSION['error'] = "Error In User Deletion Process";
}
header("Location:" . $_SERVER['HTTP_REFERER']);
}, 'post');

//Delete grade
Router::add('/student/grade/([0-9]*)/destroy', function ($grade_id){
$g = new Grade();
$r = $g->destroy($grade_id);
if($r){
$_SESSION['message'] = "Grade deleted";
}else{
$_SESSION['error'] = "Error In Grade Deletion Process";
}
header("Location:" . $_SERVER['HTTP_REFERER']);
}, 'post');

//Export data
Router::add('/board/([1-2])/export', function ($board_id){
    $grade = new Grade();
    print $grade->export($board_id);
});



//Route base path
Router::run('/');