<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once './config/config.php';

$autoload->loader("Controller");
$autoload->loader("Model");


new controller\Controller();
echo "<br>";
new model\Model();