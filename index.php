<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__ . '/stphp/STPHP.class.php';

stphp\STPHP::registerExtensions();
stphp\STPHP::registerAutoload();

$app = new stphp\STPHP();

$rest = new stphp\rest\Request();
$rest->handle();
