<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate User object
  $user = new User($db);

  // Get ID
  $user->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get raw posted data
  //$data = json_decode(file_get_contents("php://input"));
  // Set ID to update
  //$User->id = $data->id;

  // Delete User
  if($user->delete()) {
    echo json_encode(
      array('message' => 'User Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Deleted')
    );
  }
