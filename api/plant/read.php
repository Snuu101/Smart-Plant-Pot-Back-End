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

  // Blog plant query
  $result = $plant->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any plants
  if($num > 0) {
    // plant array
    $plants_arr = array();
    $plants_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $plant_item = array(
        'id' => $id,
        'name' => $name,
        'date_added' => $date_added,
        'owner_id' => $owner_id,
        'status' => $status,
        'temperature_treshold' => $temperature_treshold,
        'humidity_treshold' => $humidity_treshold,
        'active' => $active,
        'profile_image_id' => $profile_image_id,
        'type' => $type,
        'curr_temperature' => $curr_temperature,
        'curr_humidity_air' => $curr_humidity_air,
        'curr_humidity_soil' => $curr_humidity_soil
      );

      // Push to "data"
      //array_push($plants_arr, $plant_item);
      array_push($plants_arr['data'], $plant_item);
    }

    // Turn to JSON & output
    print_r(json_encode($plants_arr, JSON_NUMERIC_CHECK, JSON_FORCE_OBJECT));

  } else {
    // No plants
    echo json_encode(
      array('message' => 'No Plants Found')
    );
  }
