<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}

class BadRequest extends HttpException {
  public function __construct($message = '<h1>400 Bad Request</h1>') {
    parent::__construct($message, 400);
    $this->render($message);
  }
}