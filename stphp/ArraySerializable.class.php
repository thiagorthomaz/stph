<?php

namespace stphp;

/**
 *
 * @author thiago
 */
interface ArraySerializable {
  public function arraySerialize();
  /*
  public function arraySerialize() {
    $vars = get_object_vars($this);
    return $vars;
  }
  */
  
}