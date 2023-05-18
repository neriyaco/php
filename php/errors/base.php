<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}

class HttpException extends Exception {
  public function __construct($message = '<h1>500 Internal Server Error</h1>', $code = 500) {
    $this->code = $code;
    $this->render($message);
  }

  protected $code;

  protected function render($message) {
    http_response_code($this->code);
    // if message is not html, check if it is json
    if (is_array($message)) {
      $message = json_encode($message);
      header('Content-Type: application/json');
    } else if (strpos($message, '<') === false) {
      header('Content-Type: text/plain');
    }
    echo $message;
    die;
  }
}