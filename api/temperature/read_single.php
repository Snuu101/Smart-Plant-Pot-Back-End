<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Plant.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog plant object
  $plant = new Plant($db);

  // Get ID
  $tmpId = isset($_GET['id']) ? $_GET['id'] : die();
  $plant->setId($tmpId);

  // Get plant
  $plant->read_single();

  // Create array
  $plant_arr = array(
    'id' => $plant->getId(),
    'name' => $plant->getName(),
    'date_added' => $plant->getDate_added(),
    'owner_id' => $plant->getOwner_id(),
    'status' => $plant->getStatus(),
    'temperature_treshold' => $plant->getTemperature_treshold(),
    'humidity_treshold' => $plant->getHumidity_treshold(),
    'active' => $plant->getActive(),
    'profile_image_id' => $plant->getProfile_image_id(),
    'type' => $plant->getType()
  );

  // Make JSON
  echo json_encode($plants_arr, JSON_NUMERIC_CHECK);
