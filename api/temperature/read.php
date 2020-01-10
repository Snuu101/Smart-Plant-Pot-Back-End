<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Temperature.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate temperature object
  $temperature = new Temperature($db);

  // temperature read query
  $result = $temperature->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any temperatures
  if($num > 0) {
        // temp array
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
        // No temperatures
        echo json_encode(
          array('message' => 'No Temperatures Found')
        );
  }
