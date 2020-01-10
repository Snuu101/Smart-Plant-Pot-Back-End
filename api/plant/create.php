<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Plant.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Plant object
  $plant = new Plant($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $plant->setName($data->name);
  $plant->setOwner_id($data->owner_id);
  $plant->setStatus($data->status);
  $plant->setTemperature_treshold($data->temperature_treshold);
  $plant->setHumidity_treshold($data->humidity_treshold);
  $plant->setActive($data->active);
  $plant->setProfile_image_id($data->profile_image_id);
  $plant->setType($data->type);

  // Create plant
  if($plant->create()) {
    echo json_encode(
      array('message' => 'Plant Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Plant Not Created')
    );
  }
