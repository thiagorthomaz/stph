<?php

namespace stphp;

/**
 * Description of Session
 *
 * @author thiago
 */
class Session implements \stphp\iSession {
  
  public function __construct() {
    
  }
  
  public function start(){
    if (session_status() == 1){
      session_start();  
    }
  }
  
  public function close(){
    session_destroy();
  }

  public function delete($instance_name) {
    unset($_SESSION[$instance_name]);
  }

  public function read($instance_name) {
    if (isset($_SESSION[$instance_name])){
      return $_SESSION[$instance_name];  
    }
    return null;    
  }

  public function write($instance_name, $data) {
    return $_SESSION[$instance_name] = $data;
  }

}
