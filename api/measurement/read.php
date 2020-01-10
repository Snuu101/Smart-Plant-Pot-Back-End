<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Measurement.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Measurement object
  $measurement = new Measurement($db);

  // Measurement read query
  $result = $measurement->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any Measurements
  if($num > 0) {
        // temp array
        $measurement_arr = array();
        $measurement_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $measurement_item = array(
            'id' => $id,
            'date' => $date,
            'plant_id' => $plant_id,
            'unit' => $unit,
            'value' => $value,
            'type' => $type
          );

          // Push to "data"
          array_push($measurement_arr['data'], $measurement_item);
        }

        // Turn to JSON & output
        echo json_encode($measurement_arr);

  } else {
        // No Measurements
        echo json_encode(
          array('message' => 'No Measurements Found')
        );
  }
