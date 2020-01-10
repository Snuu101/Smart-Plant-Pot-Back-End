<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog User object
  $user = new User($db);

  // Get raw Usered data
  $data = json_decode(file_get_contents("php://input"));

  // Set properties to update
  $user->setId($data->id);
  $user->setUser_Name($data->user_name);
  $user->setEmail($data->email);
  $user->setPassword($data->password);

  // Update User
  if($user->update()) {
    echo json_encode(
      array('message' => 'User Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Updated')
    );
  }
