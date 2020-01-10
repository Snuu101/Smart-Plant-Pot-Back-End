<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Temperature.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Temperature object
  $temperature = new Temperature($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $temperature->plant_id = $data->plant_id;
  $temperature->unit = $data->unit;
  $temperature->value = $data->value;

  // Create temperature
  if($temperature->create()) {
    echo json_encode(
      array('message' => 'Temperature Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Temperature Not Created')
    );
  }
