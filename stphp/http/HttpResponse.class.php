<?php

namespace stphp\http;

/**
 * Description of HttpResponse
 *
 * @author thiago
 */
class HttpResponse {
  
  const JSON = "json";
  const HTML = "html";


  /**
   * Type of response: JSON, HTML, XML
   * 
   * @var string
   */
  protected $type;
  
  /**
   * Specific cookie for the response
   * 
   * @var array
   */
  protected $cookie;

  /**
   * Add header for the response with name and value
   * 
   * @var array
   */
  protected $header;

  /**
   * HTTTP code status responses:  10X, 20X, 30X, 40X, 50X
   * 
   * @var int
   */
  protected $status;
  
  /**
   * @Exemple ("class_name" => "method_name")
   * 
   * Function will be executed after the request
   * 
   * @var array
   */
  protected $action;
  
  /**
   * URL to redirect after the request
   * 
   * @var string
   */
  protected $redirect;
  
  function getType() {
    return $this->type;
  }

  function getCookie() {
    return $this->cookie;
  }

  function getHeader() {
    return $this->header;
  }

  function getStatus() {
    return $this->status;
  }

  function getAction() {
    return $this->action;
  }

  function getRedirect() {
    return $this->redirect;
  }

  function setType($type = self::JSON) {
    $this->type = $type;
  }

  function setCookie($cookie) {
    $this->cookie = $cookie;
  }

  function setHeader($header) {
    $this->header = $header;
  }

  function setStatus($status) {
    $this->status = $status;
  }

  function setAction($action) {
    $this->action = $action;
  }

  function setRedirect($redirect) {
    $this->redirect = $redirect;
  }


  
}
