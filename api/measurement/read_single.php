Measurement<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Measurement.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog Measurement object
  $measurement = new Measurement($db);

  // Get ID
  $measurement->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $measurement->read_single();

  // Create array
  $measurement_arr = array(
    'id' => $measurement->id,
    'date' => $measurement->date,
    'plant_id' => $measurement->plant_id,
    'created_at' => $measurement->created_at,
    'unit' => $measurement->unit,
    'value' => $measurement->value
  );

  // Make JSON
  print_r(json_encode($measurement_arr));
