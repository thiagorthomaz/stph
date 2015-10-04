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
  private static $namespaces = array();
  
  public static function getExtensions() {
    return self::$extensions;
  }

  public static function setExtensions($extensions) {
    self::$extensions = $extensions;
  }
  
  public static function addNamespace($namespace, $base_dir = null){
    
    if (is_null($base_dir)){
      $base_dir = __DIR__ . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "../";
      self::$namespaces[$namespace] = $base_dir . $namespace;
      
    } else {
      self::$namespaces[$namespace] = $base_dir;
    }
    
  }
  
  /**
  * STPHP autoloader
  */
  public static function autoload($className)
  {
    
    $namespace = self::getNamespace($className);
    $class_parts = explode("\\", $className);
    $className = array_pop($class_parts);

    foreach (self::$extensions as $ext) {
      
      $fileName  = self::$namespaces[$namespace];
      $fileName .= DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $className . $ext;
      $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);
      
      if (file_exists($fileName)) {
          require $fileName;
          return true;
      }  
    }
    
    throw new \stphp\Exception\AutoloadException("Autoload fail!");
  
  }
  
  private static function getNamespace($className){
    
    $parts = explode("\\", $className);
    array_pop($parts);

    $namespace = "";
    foreach ($parts as $i => $p) {
      
      if ($i > 0){
        $namespace .=  "\\" . $p;
      } else {
        $namespace .= $p;
      }
      
    }

    return $namespace;

  }


  /**
  * Register STPHP's PSR-0 autoloader
  */
  public static function registerAutoloader()
  {
    spl_autoload_register(__NAMESPACE__ . "\\AutoLoad::autoload");
  }
    
  
}
