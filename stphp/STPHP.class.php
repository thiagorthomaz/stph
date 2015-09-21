<?php

namespace stphp;

require_once __DIR__ . '/config/AutoLoad.class.php';

/**
 * Description of STPHP
 *
 * @author thiago
 */
class STPHP {
  
  const VERSION = "0.0.1";
  
  /**
   *
   * @var stphp\rest\Request
   */
  private $request;
          
  function __construct() {
    $this->request = new \stphp\rest\Request();
  }

  
  public static function registerAutoload(){
    \stphp\config\AutoLoad::registerAutoloader();
  }
  
  public static function registerExtensions(){
    $extensions = array('.class.php', '.php');
    \stphp\config\AutoLoad::setExtensions($extensions);
  }

  /**
   * Find a way to improve the method.
   * 
   */
  public function handle(){

    $map = $this->getClassMap();

    $namespace  = $map->getNamespace();
    $class      = $map->getClass();
    $method     = $map->getMethod();
    $params     = $map->getParameters();
    
    $full_name = $namespace.  "\\" . $class;
    
    $rc = new \ReflectionClass($full_name);
    $obj = $rc->newInstance();

    if (!is_null($map->getMethod()) && method_exists($obj, $method) ) {
      $data = call_user_func(array($obj, $method), $params);
    }
    
    $this->sendData($data);
    
  }
  
  /**
   * @TODO improve this function
   * 
   * @return \stphp\rest\RequestMap
   * @throws \stphp\Exception\RestException
   */
  public function getClassMap(){
    $this->parameters = $this->request->parameters();
    
    $map = new \stphp\rest\RequestMap();

    $nodes_path = array('app\controller', 'app\view');
    
    $parameters = $this->request->parameters();
    $get = $parameters['GET'];

    foreach ($nodes_path as $path){
      
      $path_parts = explode("\\", $path);
      $sub_namespace = $path_parts[1];
      
      $class_parts = explode($sub_namespace, $get[1]);
      
      if (isset($class_parts[1])){
        $class = $class_parts[1];

        $map->setNamespace($path);
        $map->setClass($class);
        
        unset($get[0]);
        unset($get[1]);
        
        if (isset($get[2])){
          $map->setMethod($get[2]);
          unset($get[2]);
        }
        
        if (isset($get[3]) || isset($parameters['POST'])){
          $map->setParameters($this->request->parameters());
          unset($get[3]);
        }
        
        return $map;
        
      }
      
    }

    throw new \stphp\Exception\RestException("You should not access another class beyond View or Controller from a URL.");
    
  }
 
  private function sendData(\stphp\rest\iResponse $response) {
    echo $response->output();
  }
  
}
