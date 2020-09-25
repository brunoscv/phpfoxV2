<?php

if (array_key_exists('HTTP_ORIGIN', $_SERVER)) { 
    $origin = $_SERVER['HTTP_ORIGIN']; 
} 
else if (array_key_exists('HTTP_REFERER', $_SERVER)) { 
    $origin = $_SERVER['HTTP_REFERER']; 
} else { 
    $origin = $_SERVER['REMOTE_ADDR']; 
}
$allowed_http_origins   = array(
    "http://crm-church.test",
    "https://crmdev.ministrycrm.us",
    "https://crmprod.ministrycrm.us",
);
if (in_array($origin, $allowed_http_origins)){
    header("Access-Control-Allow-Origin: " . $origin);
}

header("Access-Control-Allow-Headers: Authorization,Content-Type,account-id,X-Requested-With,Accept,Origin,X-XSRF-TOKEN");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT, PATCH");
header('Access-Control-Allow-Credentials: true');

define('PHPFOX_PARENT_DIR', __DIR__ . DIRECTORY_SEPARATOR);

require('./PF.Base/start.php');

