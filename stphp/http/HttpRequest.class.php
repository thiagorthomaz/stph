<?php

namespace stphp\http;

/**
 * HttpRequest is a representational request class. 
 * All request GET, POST, PUT and SESSION parameters is encapsuled in this class.
 *
 * @author thiago
 */
class HttpRequest {
  
  /**
   * Request URL
   * 
   * @var string 
   */
  private $url;
  
  /**
   * HOST request
   * 
   * @var string 
   */
  private $host;
  
  /**
   * Request parameters
   * 
   * @var array
   */
  private $params;
  
  /**
   * Request method: POST, GET, PUT, DELETE
   * @var string
   */
  private $method;
  
  /**
   * Return a param value by the key
   * 
   * @param string $name
   * @return mixed
   */
  public function getParams($name) {

    if (isset($this->params[$name])){
      return $this->params[$name];
    } else {
      return null;
    }
    
  }

  /**
   * Return a string value of the session param by the key
   * @param string $name
   * @return string
   */
  public function getSession($name) {
    if (isset($this->session[$name])) {
      return $this->session[$name];
    } else {
      return null;
    }
  }

  /**
   * Return a string of the URL request
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }
  
  function getHost() {
    return $this->host;
  }

  function setHost($host) {
    $this->host = $host;
  }
  
  function setUrl($url) {
    $this->url = $url;
  }

  
    /**
   * Set the params array
   * 
   * @param Array $params
   */
  public function setParams($params) {
    if (!is_array($params)){
      throw new HttpRequestException('$params must be a Array');
    }
    if (!is_array($this->params)){
      $this->params = array();
    }
    array_merge($this->params, $params);

  }

  /**
   * Add a new param
   * 
   * @param mixed $key
   * @param mixed $value
   */
  public function addParam($key, $value){
    if (!isset($this->params)){
      $this->params = array();
    }
    $this->params[$key] = $value;
  }

  /**
   * Remove a param
   * @param mixed $key
   */
  public function removeParam($key){
    if (isset($this->params)){
      unset($this->params[$key]);
    }
  }
  
  /**
   * Return common methods for HTTP/1.1
   * 
   * @url http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html
   * @return string
   */
  public function getMethod(){
    $this->method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    return $this->method;
  }
  
  /**
   * Verify if is a POST request
   * @return boolean
   */
  public function isPost(){
    return $this->getMethod() === "POST";
  }
  
  /**
   * Verify if is a PUT request
   * @return boolean
   */
  public function isPut(){
    return $this->getMethod() === "PUT";
  }
  
  /**
   * Verify if is a GET request
   * @return boolean
   */
  public function isGet(){
    return $this->getMethod() === "GET";
  }
  
  /**
   * Verify if is a DELETE request
   * @return boolean
   */
  public function isDelete(){
    return $this->getMethod() === "DELETE";
  }
  
  /**
   * Associative array of all the HTTP headers in the current request
   * 
   * @param string $key
   * @return mixed
   */
  public function getHttpHeader($key = ""){
    if (empty($key)){
      return getallheaders();
    } else {
      $headers = getallheaders();
      return $headers[$key];
    }
    
  }
  
}
