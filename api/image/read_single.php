<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Image.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog Image object
  $image = new Image($db);

  // Get ID
  $image->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $image->read_single();

  // Create array
  $image_arr = array(
    'id' => $image->id,
    'date' => $image->date,
    'plant_id' => $image->plant_id,
    'path' => $image->path
  );

  // Make JSON
  print_r(json_encode($image_arr));
