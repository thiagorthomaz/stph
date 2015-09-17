<?php

namespace stphp\rest;


/**
 * Description of Request
 *
 * @author thiago
 */
class Request {
  
  private $url_elements;
  private $method;
  private $parameters = array();
  private $format = "json";
  private $mode = "";


  public function __construct() {
    $this->method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    $this->parameters = explode("/", filter_input(INPUT_SERVER, "PATH_INFO"));

  }
  
  public function handle(){
    
    if ($this->method == "PUT" || $this->method == "POST"){
      $data = $this->getData();
      $this->parameters[] =  $data;
    }
    
    $map = $this->getClassMap();
    
    $namespace  = $map->getNamespace();
    $class      = $map->getClass();
    $method     = $map->getMethod();
    $params     = $map->getParameters();
    
    $full_name = "\app\\" . $namespace.  "\\" . $class;
    $rc = new \ReflectionClass($full_name);
    $obj = $rc->newInstance();

    if (!is_null($map->getMethod()) && method_exists($obj, $method) ) {
      $data = call_user_func(array($obj, $method), $params);
    }
    
    $this->sendData($data);
    
  }
  
  private function getClassMap(){
    
    $map = new \stphp\rest\RequestMap();
    
    
    $permitted_paths = array('controller', 'view');
    
    foreach ($permitted_paths as $path){
      
      if (isset(explode($path, $this->parameters[1])[1])){
        
        $map->setNamespace($path);
        $map->setClass(explode($path, $this->parameters[1])[1]);
        
        unset($this->parameters[0]);
        unset($this->parameters[1]);
        
        if (isset($this->parameters[2])){
          $map->setMethod($this->parameters[2]);
          unset($this->parameters[2]);
        }
        
        if (isset($this->parameters[3])){
          $map->setParameters($this->parameters[3]);
          unset($this->parameters[3]);
        }
        
        return $map;
        
      }
      
    }

    throw new \stphp\Exception\RestException("You should not access another class beyond View or Controller from a URL.");
    
  }
  
  private function sendData(\stphp\rest\iResponse $response) {

    echo $response->output();
      
      
  }
    
  private function getData(){
    $json_to_array = json_decode(file_get_contents('php://input'), true);
    $data = array_merge($_REQUEST, $json_to_array);
    return $data;
  }

  
  
  
}
