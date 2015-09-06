<?php

namespace stphp;

require_once __DIR__ . '/config/AutoLoad.class.php';

/**
 * Description of STPHP
 *
 * @author thiago
 */
class STPHP {
  
  const VERSION = "0.0.1";
  
  public static function registerAutoload(){
    \stphp\config\AutoLoad::registerAutoloader();
  }
  
  public static function registerExtensions(){
    $extensions = array('.php', '.class.php');
    \stphp\config\AutoLoad::setExtensions($extensions);
  }

  
  
  
}
