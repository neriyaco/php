<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}
require_once 'database/models/user.php';

class UsersController {
  public function __construct() {
    $this->model = new UserModel();
  }

  protected ?UserModel $model = null;

  public function get() {
    // if we have an id in the query string, return only that user
    if (isset($_GET['id'])) {
      $userId = $_GET['id'];
      $user = $this->model->find(['id' => $userId]);
      echo json_encode($user[0]);
      return;
    }
    $users = $this->model->find();
    // make sure we return only the data we need
    $users = array_map(function($user) {
      return [
        'id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
      ];
    }, $users);
    echo json_encode($users);
  }

  public function post() {
    $user = $this->model->create($_POST);
    echo json_encode($user);
  }

  public function delete() {
    $userId = $_GET['id'];
    $this->model->delete(['id' => $userId]);
  }
}