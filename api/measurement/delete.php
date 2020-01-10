<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Measurement.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Measurement object
  $measurement = new Measurement($db);

  // Get ID
  $measurement->id = isset($_GET['id']) ? $_GET['id'] : die();
  
  // Get raw posted data
  //$data = json_decode(file_get_contents("php://input"));
  // Set ID to DELETE
  //$measurement->id = $data->id;

  // Delete Measurement
  if($measurement->delete()) {
    echo json_encode(
      array('message' => 'Measurement deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Measurement not deleted')
    );
  }
