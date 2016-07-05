<?php

namespace stphp\http;

/**
 *
 * @author thiago
 */
interface HttpCommand {
  public function executeRequest(\stphp\http\HttpRequest $request);
  public function executeResponse(\stphp\http\HttpResponse $response);
}
