<?php

namespace stphp\http;

/**
 * Description of HttpRequestException
 *
 * @author thiago
 */
class HttpRequestException extends \stphp\Exception\STException{
  
  public function __construct($message, $code = "", $previous = "") {
    parent::__construct($message, $code, $previous);
    
  }

}
