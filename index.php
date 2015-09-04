<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__ . '/stphp/STPHP.class.php';

stphp\STPHP::registerExtensions();
stphp\STPHP::registerAutoload();

$app = new stphp\STPHP();



new stphp\Controller();
/*
echo "<br>";
new stphp\Model();

echo "<br>";
new stphp\View();