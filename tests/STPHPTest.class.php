<?php

require_once __DIR__ . '/../stphp/STPHP.class.php';

/**
 * Description of STPHPTest
 *
 * @author thiago
 */
class STPHPTest extends \PHPUnit_Framework_TestCase {
  
  /**
   * Test the AutoLoad.
  * @expectedException \stphp\Exception\AutoloadException
  */
  public function testRegisterAutoload(){
    
    stphp\STPHP::registerExtensions();
    stphp\STPHP::registerAutoload();
    
    $invalid_class = new \stphp\ControllerInvalid();
    
  }
  
  
  
}
