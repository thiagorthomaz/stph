<?php

namespace stphp\rest;

/**
 *
 * @author thiago
 */
interface iResource {
  
  public function get();
  public function post();
  public function update();
  public function delete();
  
  
}
