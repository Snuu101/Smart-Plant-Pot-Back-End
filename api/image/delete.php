<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Image.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Image object
  $image = new Image($db);

  // Get ID
  $image->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get raw posted data
  //$data = json_decode(file_get_contents("php://input"));
  // Set ID to DELETE
  //$Image->id = $data->id;

  // Delete Image
  if($image->delete()) {
    echo json_encode(
      array('message' => 'Image deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Image not deleted')
    );
  }
