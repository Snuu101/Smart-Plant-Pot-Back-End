<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Image.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Image object
  $image = new Image($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $image->plant_id = $data->plant_id;
  $image->path = $data->path;

  // Create Image
  if($image->create()) {
    echo json_encode(
      array('message' => 'Image created')
    );
  } else {
    echo json_encode(
      array('message' => 'Image not created')
    );
  }
