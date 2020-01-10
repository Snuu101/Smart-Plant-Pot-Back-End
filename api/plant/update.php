<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Plant.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog plant object
  $plant = new Plant($db);

  // Get raw planted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $plant->setId($data->id);
  $plant->setName($data->name);
  $plant->setOwner_id($data->owner_id);
  $plant->setStatus($data->status);
  $plant->setTemperature_treshold($data->temperature_treshold);
  $plant->setHumidity_treshold($data->humidity_treshold);
  $plant->setActive($data->active);
  $plant->setProfile_image_id($data->profile_image_id);
  $plant->setType($data->type);

  // Update plant
  if($plant->update()) {
    echo json_encode(
      array('message' => 'Plant Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Plant Not Updated')
    );
  }
