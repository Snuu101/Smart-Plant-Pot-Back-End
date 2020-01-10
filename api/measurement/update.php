<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Measurement.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $measurement = new Measurement($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $measurement->id = $data->id;
  $measurement->unit = $data->unit;
  $measurement->value = $data->value;
  $measurement->plant_id = $data->plant_id;
  $measurement->type = $data->type;

  // Update post
  if($measurement->update()) {
    echo json_encode(
      array('message' => 'Measurement Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Measurement not updated')
    );
  }
