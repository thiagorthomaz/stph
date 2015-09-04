<?php

require_once 'AutoLoad.class.php';

$folders_list = array('model', 'view','controller');
$extensions_list = array('.php', '.class.php');

define("DIR_BASE", "/var/www/html/");
define("PROJECT_NAME", "stphp");

$autoload = new AutoLoad();
$autoload->setFolders_list($folders_list);
$autoload->setExtensions($extensions_list);


