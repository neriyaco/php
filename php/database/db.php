<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}

class Db {
  private function __construct() {
    $this->connection = new mysqli(
      $_ENV['DB_HOST'],
      $_ENV['DB_USERNAME'],
      $_ENV['DB_PASSWORD'],
      $_ENV['DB_DATABASE']
    );
    if ($this->connection->connect_errno) {
      throw new Exception($this->connection->connect_error);
    }
  }

  static function i() {
    if (self::$instance === null) {
      self::$instance = new Db();
    }
    return self::$instance;
  }
  
  public $connection = null;
  private static ?Db $instance = null;
}
