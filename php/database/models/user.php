<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}
require_once 'database/db.php';
require_once 'database/models/base.php';

class UserModel extends BaseModel
{
  function create($data)
  {
    $this->validate($data);

    $conn = $this->db->connection;
    $query = $conn->prepare('INSERT INTO users (username, email, password, birthdate, phone_number, url) VALUES (?, ?, ?, ?, ?, ?)');
    $query->bind_param('ssssss', $data['username'], $data['email'], $data['password'], $data['birthdate'], $data['phone_number'], $data['url']);
    $query->execute();
    $query->close();
  }

  protected $table = 'users';

  function createTable()
  {
    // Create table if not exists
    $this->db->connection->query('CREATE TABLE IF NOT EXISTS users (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100) NOT NULL,
      email VARCHAR(100) NOT NULL,
      password VARCHAR(100) NOT NULL,
      birthdate DATE NOT NULL,
      phone_number VARCHAR(10) NOT NULL,
      url VARCHAR(200) NOT NULL
    )');
  }

  function validate($data)
  {
    $errors = [];
    if (!isset($data['username']) || $data['username'] === '') {
      $errors['username'] = 'Username is required';
    }
    if (!isset($data['email']) || $data['email'] === '') {
      $errors['email'] = 'Email is required';
    }
    if (!isset($data['password']) || $data['password'] === '') {
      $errors['password'] = 'Password is required';
    }
    if (!isset($data['birthdate']) || $data['birthdate'] === '') {
      $errors['birthdate'] = 'Birthdate is required';
    }
    if (!isset($data['phone_number']) || $data['phone_number'] === '') {
      $errors['phone_number'] = 'Phone number is required';
    }
    if (!isset($data['url']) || $data['url'] === '') {
      $errors['url'] = 'URL is required';
    }
    if (count($errors) == 0) {
      // Verify username letters only
      if (!preg_match('/^[a-zA-Z]+$/', $data['username'])) {
        $errors['username'] = 'Username must contain only letters';
      }

      // Verify password, 8 chars min, 1 lowercase, 1 uppercase and 1 special sign at least.
      if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', $data['password'])) {
        $errors['password'] = 'Password must be at least 8 characters long, contain at least 1 lowercase letter, 1 uppercase letter and 1 special sign';
      }

      // Verify email format
      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email must be a valid email address';
      }

      // Verify date format
      if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['birthdate'])) {
        $errors['birthdate'] = 'Birthdate must be a valid date';
      }
      $d = DateTime::createFromFormat('Y-m-d', $data['birthdate']);

      // Verify date is valid
      if (!($d && $d->format('Y-m-d') === $data['birthdate'])) {
        $errors['birthdate'] = 'Birthdate must be a valid date';
      }

      // Verify phone number format
      if (!preg_match('/^\d{10}$/', $data['phone_number'])) {
        $errors['phone_number'] = 'Phone number must be a valid phone number';
      }

      // Verify URL format
      $url = filter_var($data['url'], FILTER_SANITIZE_URL);
      if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $errors['url'] = 'URL must be a valid URL';
      }

      // is username unique?
      $query = $this->find(['username' => $data['username']]);
      if (count($query) > 0) {
        $errors['username'] = 'Username already exists';
      }
    }

    if (count($errors) > 0) {
      throw new BadRequest(['errors' => $errors]);
    }
  }
}
