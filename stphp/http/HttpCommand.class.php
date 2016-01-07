<?php

namespace stphp\http;

/**
 *
 * @author thiago
 */
interface HttpCommand {
  public function execute(\HttpRequest $request, \HttpResponse $response);
}
