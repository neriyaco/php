<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}

require_once 'api/users.php';

$routes = [
  '/' => 'pages/home.php',
  '/users' => 'pages/users.php',
  '/register' => 'pages/register.php',
];

$apiRoutes = [
  '/api/users' => UsersController::class,
  '/api/register' => UsersController::class,
];
