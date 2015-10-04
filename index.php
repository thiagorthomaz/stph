<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__ . '/stphp/STPHP.class.php';

stphp\config\AutoLoad::addNamespace("stphp");
stphp\config\AutoLoad::addNamespace("stphp\\Database");
stphp\config\AutoLoad::addNamespace("stphp\\Exception");
stphp\config\AutoLoad::addNamespace("stphp\\rest");
stphp\config\AutoLoad::addNamespace("app\\controller");
stphp\config\AutoLoad::addNamespace("app\\model");
stphp\config\AutoLoad::addNamespace("app\\view");
stphp\config\AutoLoad::addNamespace("app\\exception");

stphp\config\AutoLoad::addNamespace("Lcobucci\JWT", __DIR__ . "/vendor/lcobucci/jwt/src");
stphp\config\AutoLoad::addNamespace("Lcobucci\JWT\Parsing", __DIR__ . "/vendor/lcobucci/jwt/src/Parsing");
stphp\config\AutoLoad::addNamespace("Lcobucci\JWT\Encoder", __DIR__ . "/vendor/lcobucci/jwt/src/Encoder");
stphp\config\AutoLoad::addNamespace("Lcobucci\JWT\Claim", __DIR__ . "/vendor/lcobucci/jwt/src/Claim");

stphp\STPHP::registerExtensions();
stphp\STPHP::registerAutoload();

$session = new stphp\Session();
$session->start();

$app = new stphp\STPHP();
$app->handle();

