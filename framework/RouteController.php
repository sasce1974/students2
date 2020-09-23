<?php
//Base route
Router::add('/', function (){
global $include;
$include = '../includes/main.php';
});

//Show board route
Router::add('/board/([0-9]*)',function($id){
global $include, $board, $users;
$include = '../includes/board.php';
$board = new Board();
$board = $board->whereId($id);
$user = new User();
$users = $user->where('board_id', $board->id);
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
}
});

// Create Student
Router::add('/board/([0-9]*)/student/store', function ($id){
$board = new Board();
$board = $board->whereId($id);
if($board){
$user = new User();
if(isset($_POST['name']) && trim($_POST['name']) !== ""){
$name = filter_input(INPUT_POST, 'name',
FILTER_SANITIZE_STRING);
$data = array();
$data['board_id'] = $board->id;
$data['name'] = $name;
$r = $user->create($data);
if($r){
$_SESSION['message'] = "Student Created";
}else{
$_SESSION['error'][] = "Error In Student Creation Process";
}
}else{
$_SESSION['error'][] = "Please Insert Student Name";
}
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
$data = array();

$data['user_id'] = $student_id;
$data['grade'] = $grade;

//Check if there are 4 grades for this user
if(count($user->grade($student_id)) > 3){
    $_SESSION['error'][] = "Maximum 4 grades allowed per user";
    header("Location:" . $_SERVER['HTTP_REFERER']);
    exit();
}

$r = $g->create($data);
if($r){
$_SESSION['message'] = "Grade Inserted";
}else{
$_SESSION['error'][] = "Error In Grade Creation Process";
}
}else{
$_SESSION['error'][] = "Please Insert Grade";
}
header("Location:" . $_SERVER['HTTP_REFERER']);
}, 'post');

//Delete student
Router::add('/board/([0-9]*)/student/([0-9]*)/destroy', function ($board_id, $student_id){
$user = new User();
$r = $user->destroy($student_id);
if($r){

$_SESSION['message'] = "User with $r grades deleted";

}else{
$_SESSION['error'][] = "Error In User Deletion Process";
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
$_SESSION['error'][] = "Error In Grade Deletion Process";
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