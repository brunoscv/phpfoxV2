<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");

define('PHPFOX_PARENT_DIR', __DIR__ . DIRECTORY_SEPARATOR);

require('./PF.Base/start.php');

