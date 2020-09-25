<?php

$request_headers = apache_request_headers();
$http_origin = $request_headers['Origin'];
$allowed_http_origins   = array(
    "http://crm-church.test",
    "https://crmdev.ministrycrm.us",
    "https://crmprod.ministrycrm.us",
);
if (in_array($http_origin, $allowed_http_origins)){
    header("Access-Control-Allow-Origin: " . $http_origin);
}
header("Access-Control-Allow-Headers: AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");

define('PHPFOX_PARENT_DIR', __DIR__ . DIRECTORY_SEPARATOR);

require('./PF.Base/start.php');

