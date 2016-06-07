<?php

namespace stphp\http;

/**
 * Description of HttpResponseException
 *
 * @author toloi
 */
class HttpResponseException extends extends \stphp\Exception\STException{
  
  public function __construct($message, $code, $previous = "") {
    parent::__construct("Response error: " . $message, $code, $previous);
  }
  
}
