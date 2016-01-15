<?php

namespace stphp;

/**
 * Description of Controller
 *
 * @author thiago
 */
class Controller extends \stphp\http\HttpServlet {
  
  public function __construct() {
    parent::__construct();
  }
  
  public function prepareRequest(\stphp\Database\iDataModel &$model){
    
    $request = $this->getRequest();
    $params = $request->getAllParams();
    
    if (is_null($params)){
      return null;
    }

    foreach ($params as $key => $value){
      $method_name = str_replace("_", "", $key);
      call_user_func(array($model, "set" . ucfirst($method_name)), $value );
    }
    return $model;
  }
  
  
}
