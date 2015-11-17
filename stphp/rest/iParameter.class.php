<?php

namespace stphp\rest;

/**
 *
 * @author thiago
 */
interface iParameter {
  
  public function get($param);
  public function set($param_name, $value);

}
