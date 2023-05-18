<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}

class NotFound extends HttpException {
  public function __construct($message = '<h1>404 Not Found</h1>') {
    parent::__construct($message, 404);
    $this->render($message);
  }
}