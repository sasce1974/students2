<?php

class ErrorManagement
{

    private $debug = false;

    function __construct()
    {
        if(ENV === 'local'){
            $this->debug = true;
            ini_set('display_errors', 1);
        }else{
            $this->debug = false;
            ini_set('display_errors', 0);
            ini_set('log_errors', 1);
        }

        if (session_id() == "") {
            if(!headers_sent()) {
                session_start();
            }
        }
        if(!isset($_SESSION['error'])) $_SESSION['error'] = array();

        //	Use	my error handler:
        set_error_handler(array($this, 'my_error_handler'));
    }




    function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars){

        $message = "An error occurred in file " . $e_file . " on line " . $e_line . ", " . $e_message;
        //Append $e_vars to	the	$message:
        $message .= print_r($e_vars, 1);

        if ($this->debug){	// Show the error.
            error_log($message);
            $_SESSION['error'] = $message;
        }else{
            //	Log	the	error:
            error_log ($message, 1, LOG_TO_EMAIL);	//	Send email.
            //	Only print an error message if the error isn't a notice or strict.
            if(($e_number != E_NOTICE) && ($e_number < 2048)) {
                $_SESSION['error'] = "A system error occurred. We apologize for the inconvenience.";
            }
        }
        header("Location: " . BASE_URL . "/error.php");
        exit();
    }


    function errorMessage($e = null, $user_message = null){

        if($this->debug){
            if($e === null){
                error_log("Error: ". $user_message);
                $_SESSION['error'] = "Error: ". $user_message;
            }else {
                error_log("Error: " . $e->getMessage() . " in file: " . $e->getFile() . " at line: " . $e->getLine());
                $_SESSION['error'] = "Error: " . $e->getMessage() . " in file: " . $e->getFile() . " at line: " . $e->getLine();
            }
        }else{
            $_SESSION['error'] = "A system error occurred. We apologize for the inconvenience. " . $user_message;
        }
        header("Location: " . BASE_URL . "/error.php");
        exit();
    }


}