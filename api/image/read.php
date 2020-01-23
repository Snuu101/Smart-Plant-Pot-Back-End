<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Image.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Image object
  $image = new Image($db);

  // Image read query
  $result = $image->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any images
  if($num > 0) {
        // temp array
        $image_arr = array();
        $image_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $image_item = array(
            'id' => $id,
            'date' => $date,
            'plant_id' => $plant_id,
            'path' => $path,
          );

          // Push to "data"
          array_push($image_arr['data'], $image_item);
        }

        // Turn to JSON & output
        echo json_encode($image_arr);

  } else {
        // No images
        echo json_encode(
          array('message' => 'No images found')
        );
  }
