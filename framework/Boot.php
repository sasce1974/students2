<?php

require_once '../.php';
require_once 'ErrorManagement.php';
require_once 'Router.php';


class Boot
{
    public $con = null;
    private $error;

    function __construct()
    {
        $this->error = new ErrorManagement();
        if(!defined('DB_NAME') || DB_NAME == '') $this->error->errorMessage(null,'Database not configured');
        $this->connect();
    }

    private function connect(){
        try {
            $this->con = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (Exception $e){
            $this->error->errorMessage($e);
        }
    }

}