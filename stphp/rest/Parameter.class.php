<?php

namespace stphp\rest;

/**
 * Description of Parameter
 *
 * @author thiago
 */
class Parameter implements \stphp\rest\iParameter{
  
  protected $parameters = array();


  public function get($param_name) {
    return $this->parameters[$param_name];
  }

  public function set($param_name, $value) {
    $this->parameters[$param_name] = $value;
  }

}
