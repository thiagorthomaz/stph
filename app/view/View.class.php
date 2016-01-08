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
  
  function noViewImplemented() {
    $c = new \app\controller\Player();
    $c->get();
    $data = array("error" => 404, "message" => "Not implemented yet.");
    $this->setData(json_encode($data));
    return $this;

  }


}
