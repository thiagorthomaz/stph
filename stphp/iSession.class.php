<?php

namespace stphp;

/**
 *
 * @author thiago
 */
interface iSession {
  
  public function read($instance_name);
  public function write($instance_name, $data);
  public function delete($instance_name);
  
}
