<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog User object
  $user = new User($db);

  // Get ID
  $tmpId = isset($_GET['id']) ? $_GET['id'] : die();
  $user->setId($tmpId);

  // Get User
  $user->read_single();

  // Create array
  $user_arr = array(
    'id' => $user->getId(),
    'user_name' => $user->getUser_name(),
    'email' => $user->getEmail(),
    'password' => $user->getPassword()
  );

  // Make JSON
  print_r(json_encode($user_arr));
