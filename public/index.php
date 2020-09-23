<?php
session_start();
require_once '../framework/Boot.php';
require_once '../framework/Model.php';
require_once '../Model/User.php';
require_once '../Model/Board.php';
require_once '../Model/Grade.php';

$boot = new Boot;
if(!defined('DB_NAME') || DB_NAME === '') exit('Application is not configured');
$include = null;

include '../framework/RouteController.php';

include '../layout/app.php';
?>
<body>
<div class="text-right pr-4 pt-4">
    <a href="/" class="btn btn-outline-secondary btn-sm">Home</a>
</div>
<?php
    if(isset($include)) include $include;
?>
</body>