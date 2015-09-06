<?php

namespace app\view;

/**
 * Description of View
 *
 * @author thiago
 */
class View implements \stphp\rest\iResponse{
  
  private $data;
  private $mode = "";
  
  public function output() {

    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Type: application/json');
    
    $options = 0;
    if ($this->mode == 'debug') {
      $options = JSON_PRETTY_PRINT;
    }

    return json_encode($this->data, $options);
    
  }
  
  function getData() {
    return $this->data;
  }

  function setData($data) {
    $this->data = $data;
  }



}
