<?php

//require_once __DIR__ . '/../stphp/STPHP.class.php';
require_once __DIR__ . '/../vendor/autoload.php';

//stphp\STPHP::registerExtensions();
//stphp\STPHP::registerAutoload();

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;


/**
 * Description of RestTest
 *
 * @author thiago
 */
class RestTest extends \PHPUnit_Framework_TestCase {
  
  public function testGET(){
    
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'http://localhost/stphp/index.php/',
        // You can set any number of default request options.
        'timeout'  => 2.0,
    ]);
    
    $response = $client->get('controllerUser');
    $code = $response->getStatusCode();
    $body = (string)$response->getBody();
    
    $this->assertEquals("200", $code);
    $this->assertJson($body);
    
  }
  
  
}
