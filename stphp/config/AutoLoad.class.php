<?php

namespace stphp\config;

require_once __DIR__ . "/../Exception/AutoloadException.class.php";

/**
 * Description of ClassLoader
 *
 * @author thiago
 */
class AutoLoad {
  
  private $class = "";
  private static $extensions = array();

  public static function getExtensions() {
    return self::$extensions;
  }

  public static function setExtensions($extensions) {
    self::$extensions = $extensions;
  }

  /**
  * STPHP autoloader
  */
  public static function autoload($className)
  {

    $base_dir = __DIR__ . "/../..";

    $className = ltrim($className, '\\');

    $namespace = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
    }
    
    foreach (self::$extensions as $ext) {
      $fileName  = $base_dir;
      $fileName .= DIRECTORY_SEPARATOR . $namespace . DIRECTORY_SEPARATOR . $className . $ext;

      if (file_exists($fileName)) {
          require $fileName;
          return true;
      }  
    }
    
    throw new \stphp\Exception\AutoloadException("Autoload fail!");
  
  }
  /**
  * Register STPHP's PSR-0 autoloader
  */
  public static function registerAutoloader()
  {
    spl_autoload_register(__NAMESPACE__ . "\\AutoLoad::autoload");
  }
    
  
}
