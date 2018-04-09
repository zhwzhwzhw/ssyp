<?php
header('content-type:text/html;charset=utf-8');
define('BASE_URL',str_replace('\\', '/', substr(dirname(__FILE__),strlen($_SERVER['DOCUMENT_ROOT']))).'/');
define('ROOT',str_replace('\\', '/', dirname(__FILE__)).'/');
define('APP_PATH','./Apps/');
define('APP_DEBUG',True);
require './ThinkPHP/ThinkPHP.php';