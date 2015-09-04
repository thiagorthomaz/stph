<?php

/**
 * Description of ClassLoader
 *
 * @author thiago
 */
class AutoLoad {
  
  private $class = "";
  private $extensions = array();
  private $folders_list = array();

  function getClass() {
    return $this->class;
  }

  function getExtensions() {
    return $this->extensions;
  }

  function getFolders_list() {
    return $this->folders_list;
  }

  function setClass($class) {
    $this->class = $class;
  }

  function setExtensions($extensions) {
    $this->extensions = $extensions;
  }

  function setFolders_list($folders_list) {
    $this->folders_list = $folders_list;
  }

  function loader($class_name){
    
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = DIR_BASE . $ds . PROJECT_NAME . $ds;
    
    foreach ($this->folders_list as $folder){
      foreach ($this->extensions as $ext){
        $filename = $base_dir . $folder . $ds . $class_name . $ext;
          if (is_readable($filename) ){;
            require_once $filename;
            return true;
          }
      }

    }
    
  }
  
  
}
