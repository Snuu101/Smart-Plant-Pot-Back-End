<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Image.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $image = new Image($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $image->id = $data->id;
  $image->path = $data->path;
  $image->plant_id = $data->plant_id;

  // Update post
  if($image->update()) {
    echo json_encode(
      array('message' => 'Image updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Image not updated')
    );
  }
