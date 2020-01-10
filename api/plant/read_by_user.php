Plant<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Plant.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog Plant object
  $plant = new Plant($db);

  // Get ID
  $plant->owner_id = isset($_GET['owner_id']) ? $_GET['owner_id'] : die();

  // Get post
  $result = $plant->read_by_user();

  // Get row count
  $num = $result->rowCount();

  // Check if any Plants
  if($num > 0) {
        // Cat array
        $plant_arr = array();
        $plant_arr['data'] = array();

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
            'type' => $type
          );

          // Push to "data"
          array_push($plant_arr['data'], $plant_item);
        }

        // Turn to JSON & output
        echo json_encode($plant_arr);

  } else {
        // No Plants
        echo json_encode(
          array('message' => 'No Plants Found')
        );
  }
