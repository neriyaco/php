<?php

define('GUARD', true);

require_once 'config/env.php';
parseEnv();

require_once 'config/routes.php';
require_once 'errors/all.php';

function error_handler() {
  $last_error = error_get_last();
  if ($last_error['type'] === E_ERROR) {
    throw new HttpException('<h1>500 Internal Server Error</h1>', 500);
    exit;
  }
}

function exception_handler() {
  throw new HttpException('<h1>500 Internal Server Error</h1>', 500);
}

//register_shutdown_function('error_handler');
set_error_handler('error_handler');
// set_exception_handler('exception_handler');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (isset($routes[$path])) {
  global $page;
  $page = $routes[$path];
  require_once 'layout/header.php';
} else if (isset($apiRoutes[$path])) {
  $class = $apiRoutes[$path];
  $controller = new $class();
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      $controller->get();
      break;
    case 'POST':
      $controller->post();
      break;
    case 'PUT':
      $controller->put();
      break;
    case 'DELETE':
      $controller->delete();
      break;
    default:
      http_response_code(405);
      exit;
  }
} else {
  header('HTTP/1.1 404 Not Found');
  exit;
}