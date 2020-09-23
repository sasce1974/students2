<?php
## APPLICATION SETTINGS ##
$app_name = 'Students';
$app_domain = 'students.test';

## DATABASE SETTINGS ##
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'qSmU9JdK3kdx4W2';
$db_name = 'students';

## APPLICATION URL and URI ##
$uri = 'C:\xampp\htdocs\classroom\students_no_frmw';
$url = 'http://students.test';

## local or production environment ##
$env = 'local';

## error logs to email ##
$email = 'someones@email.com';

define('APP_NAME', $app_name);
define('APP_DOMAIN', $app_domain);
define('DB_HOST', $db_host);
define('DB_USER', $db_user);
define('DB_PASS', $db_pass);
define('DB_NAME', $db_name);
define('BASE_URI', $uri);
define('BASE_URL', $url);
define('ENV', $env);
define('LOG_TO_EMAIL', $email);

