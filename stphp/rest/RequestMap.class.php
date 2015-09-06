<?php

namespace stphp\rest;

/**
 * Description of RequestMap
 *
 * @author thiago
 */
class RequestMap {
  
  private $namespace = null;
  private $class = null;
  private $method = null;
  private $parameters = array();
  
  /**
   * 
   * @return String
   */
  function getNamespace() {
    return $this->namespace;
  }

  /**
   * 
   * @return String
   */
  function getClass() {
    return $this->class;
  }

  /**
   * 
   * @return String
   */
  function getMethod() {
    return $this->method;
  }

  /**
   * 
   * @return Array
   */
  function getParameters() {
    return $this->parameters;
  }

  /**
   * 
   * @param String $namespace
   */
  function setNamespace($namespace) {
    $this->namespace = $namespace;
  }

  /**
   * 
   * @return String
   */
  function setClass($class) {
    $this->class = $class;
  }

  /**
   * 
   * @return String
   */
  function setMethod($method) {
    $this->method = $method;
  }

  /**
   * 
   * @param String $name
   * @param mixed $value
   */
  function setParameters($params) {
    $this->parameters = $params;
  }


  
  
}
