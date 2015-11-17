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

  }
  
  public function getMethod(){
    $this->method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    return $this->method;
  }
  
  public function isPost(){
    return $this->getMethod() === "POST";
  }
  
  public function isPut(){
    return $this->getMethod() === "PUT";
  }
  
  public function isGet(){
    return $this->getMethod() === "GET";
  }
  
  public function isDelete(){
    return $this->getMethod() === "DELETE";
  }

  /**
   * This method return union of GET and POST data as array; if doesn't exist, NULL is returned.
   * @return array|mixed|null
   */
  function parameters($key = null, $default = null) {
    $union = array_merge($this->get(), $this->post());
    return $union;
  }

  public function get(){
    $data = array();
    $data['GET'] = explode("/", filter_input(INPUT_SERVER, "PATH_INFO"));
    return $data;
  }
  
  public function post($key = null, $default = null){
    
    if ($this->isPost() || $this->isPut() || $this->isDelete()){
      $data = array();
      $json_to_array = json_decode(file_get_contents('php://input'), true);
      if (is_null($json_to_array)){
        $data[$this->getMethod()] = $_REQUEST;
      } else {
        $data[$this->getMethod()] = array_merge($_REQUEST, $json_to_array);
      }
      
      return $data;
    } else {
      return array();
    }
    
  }
  
  public function put($key = null, $default = null){
    return $this->post($key = null, $default = null);
  }
  
  public function delete($key = null, $default = null){
    return $this->post($key = null, $default = null);
  }

  
  
  
}
