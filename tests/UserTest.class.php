<?php

require_once __DIR__ . '/../stphp/STPHP.class.php';
require_once __DIR__ . '/../vendor/autoload.php';

stphp\STPHP::registerExtensions();
stphp\STPHP::registerAutoload();

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;


/**
 * Description of UserTest
 *
 * @author thiago
 */
class UserTest  extends \PHPUnit_Framework_TestCase {
  
  public function testSingUp(){
    
    
  }
  
  
}
