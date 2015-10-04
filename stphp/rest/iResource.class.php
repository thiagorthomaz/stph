<?php

namespace stphp\rest;

/**
 *
 * @author thiago
 */
interface iResource {
  
  public function get($parameters);
  public function post($parameters);
  public function update($parameters);
  public function delete($parameters);
  
  
}
