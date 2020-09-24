<?php
session_start();
require_once '../framework/Boot.php';
require_once '../framework/Model.php';
require_once '../Model/User.php';
require_once '../Model/Board.php';
require_once '../Model/Grade.php';

$boot = new Boot;

$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));

$include = null;

include '../layout/app.php';
?>
<body>
<div class="text-right pr-4 pt-4">
    <a href="/" class="btn btn-outline-secondary btn-sm">Home</a>
</div>
<div class="p-3">
    <?php
    if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
        ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>ERROR! </strong> <?php print $_SESSION['error']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    }

    if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
        ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>SUCCESS! </strong> <?php print $_SESSION['message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    }
    ?>
</div>
<?php

include '../framework/RouteController.php';
    //if(isset($include)) include $include;

function includeWithVar($filePath, $variables = array())
{
    $output = NULL;
    if(file_exists($filePath)){
        extract($variables);
        ob_start();
        include $filePath;
        $output = ob_get_clean();
    }
    print $output;
}
?>
</body>