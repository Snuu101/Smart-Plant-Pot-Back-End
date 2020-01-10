<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Temperature.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $temperature = new Temperature($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $temperature->id = $data->id;

  $temperature->name = $data->name;

  // Update post
  if($temperature->update()) {
    echo json_encode(
      array('message' => 'Temperature Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Temperature not updated')
    );
  }
