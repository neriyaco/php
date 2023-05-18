<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}

require_once 'errors/base.php';
require_once 'errors/400.php';
require_once 'errors/404.php';
