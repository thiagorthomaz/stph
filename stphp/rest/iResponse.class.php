<?php

namespace stphp\rest;

/**
 *
 * @author thiago
 */
interface iResponse {
  public function output(\stphp\http\HttpResponse $response);
}
