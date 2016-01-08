<?php

namespace stphp;

/**
 * Description of Controller
 *
 * @author thiago
 */
class Controller extends \stphp\http\HttpServlet {
  
  public function __construct() {
    $request = new \stphp\http\HttpRequest();
    $response = new \stphp\http\HttpResponse();
    $this->execute($request, $response);
  }
  
}
