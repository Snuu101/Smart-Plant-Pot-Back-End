<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Measurement.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Measurement object
  $measurement = new Measurement($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $measurement->plant_id = $data->plant_id;
  $measurement->unit = $data->unit;
  $measurement->value = $data->value;
  $measurement->type = $data->type;

  // Create Measurement
  if($measurement->create()) {
    echo json_encode(
      array('message' => 'Measurement Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Measurement Not Created')
    );
  }
