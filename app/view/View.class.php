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
  
  public function output(\stphp\http\HttpResponse $response) {

    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Type: application/json');
    
    $options = 0;
    if ($this->mode == 'debug') {
      $options = JSON_PRETTY_PRINT;
    }
    
    return $this->data;
    
  }
  
  function getData() {
    return $this->data;
  }

  function setData($data) {
    $this->data = $data;
  }

  function errOutput($message, $field, $cod_erro = null){
    
    $err= array();
    $err['error_message'] = $message;
    $err['error_field'] = $field;
    $err['error_code'] = $cod_erro;
    
    return json_encode($err);
    
  }
  
  function notFound() {
    $data = array("error" => 404, "message" => "Not found.");
    echo json_encode($data);
  }


}
