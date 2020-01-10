<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Plant.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Plant object
  $plant = new Plant($db);

  // Get ID
  $plant->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get raw posted data
  //$data = json_decode(file_get_contents("php://input"));
  // Set ID to update
  //$plant->id = $data->id;

  // Delete plant
  if($plant->delete()) {
    echo json_encode(
      array('message' => 'Plant Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Plant Not Deleted')
    );
  }
