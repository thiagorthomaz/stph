<?php

require_once __DIR__ . '/../../stphp/STPHP.class.php';
require_once __DIR__ . '/../../vendor/autoload.php';

stphp\STPHP::registerExtensions();
stphp\STPHP::registerAutoload();

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;


/**
 * Description of UserTest
 *
 * @author thiago
 */
class UsuarioTest  extends \PHPUnit_Framework_TestCase {
  
  public function testSingUp(){
    $client = new Client();
    $params = array(
        'id_perfil' => '1',
        'id_tipo' => '2',
        'login' => 'thiagotest',
        'senha' => 'phpunit'
    );
    
    $response = 
          $client->request(
            'POST', 
            'http://localhost/stphp/index.php/controllerUsuario/save', 
            array('form_params' => $params)
          );

    $code = $response->getStatusCode();
    $body = (string)$response->getBody();
    
    
    $this->assertEquals("200", $code);
    $this->assertJson($body);
    
  }
  
  
}
