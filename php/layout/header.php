<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Users Demo App</title>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>
  <div class="main">
    <header>
      <a href="/"><h1>Users Demo App</h1></a>
      <ul class="menu">
        <li><a href="users">Users</a></li>
        <li><a href="register">Register</a></li>
      </ul>
    </header>
    <div class="content">
      <div class="container">
        <?php require_once $page; ?>
      </div>
    </div>
  </div>
  <?php require_once 'layout/footer.php'; ?>
</body>