<?php
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
  $measurement->plant_id = isset($_GET['plant_id']) ? $_GET['plant_id'] : die();

  // Get post
  $result = $measurement->read_by_plant();

  // Get row count
  $num = $result->rowCount();

  // Check if any Measurements
  if($num > 0) {
        // Cat array
        $temp_arr = array();
        $temp_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $temp_item = array(
            'id' => $id,
            'date' => $date,
            'plant_id' => $plant_id,
            'unit' => $unit,
            'value' => $value
          );

          // Push to "data"
          array_push($temp_arr['data'], $temp_item);
        }

        // Turn to JSON & output
        echo json_encode($temp_arr);

  } else {
        // No Measurements
        echo json_encode(
          array('message' => 'No Measurements Found')
        );
  }
