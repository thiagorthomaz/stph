<?php

namespace stphp\http;

/**
 *
 * @author thiago
 */
interface HttpCommand {
  public function execute(\stphp\http\HttpRequest $request, \stphp\http\HttpResponse $response);
}
