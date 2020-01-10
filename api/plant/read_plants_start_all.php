<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Plant.php';
  include_once '../../models/Measurement.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog plant object
  $plant = new Plant($db);
  $plant2 = new Plant($db);
  $plant3 = new Plant($db);
  $plant->setId(1);
  $plant2->setId(2);
  $plant3->setId(3);

  // Get plant
  $plant->read_start();
  $plant2->read_start();
  $plant3->read_start();

  // plant array
  $plants_arr = array();
  $plants_arr['data'] = array();


  // Create array
  $plant_arr = array(
    'id' => $plant->getId(),
    'name' => $plant->getName(),
    'date_added' => $plant->getDate_added(),
    'owner_id' => $plant->getOwner_id(),
    'status' => $plant->getStatus(),
    'temperature_treshold' => $plant->getTemperature_treshold(),
    'humidity_treshold' => $plant->getHumidity_treshold(),
    'active' => $plant->getActive(),
    'profile_image_id' => $plant->getProfile_image_id(),
    'type' => $plant->getType(),
    'curr_temperature' => $plant->curr_temperature,
    'curr_humidity_air' => $plant->curr_humidity_air,
    'curr_humidity_soil' => $plant->curr_humidity_soil
  );
  $plant_arr2 = array(
    'id' => $plant2->getId(),
    'name' => $plant2->getName(),
    'date_added' => $plant2->getDate_added(),
    'owner_id' => $plant2->getOwner_id(),
    'status' => $plant2->getStatus(),
    'temperature_treshold' => $plant2->getTemperature_treshold(),
    'humidity_treshold' => $plant2->getHumidity_treshold(),
    'active' => $plant2->getActive(),
    'profile_image_id' => $plant2->getProfile_image_id(),
    'type' => $plant2->getType(),
    'curr_temperature' => $plant2->curr_temperature,
    'curr_humidity_air' => $plant2->curr_humidity_air,
    'curr_humidity_soil' => $plant2->curr_humidity_soil
  );
  $plant_arr3 = array(
    'id' => $plant3->getId(),
    'name' => $plant3->getName(),
    'date_added' => $plant3->getDate_added(),
    'owner_id' => $plant3->getOwner_id(),
    'status' => $plant3->getStatus(),
    'temperature_treshold' => $plant3->getTemperature_treshold(),
    'humidity_treshold' => $plant3->getHumidity_treshold(),
    'active' => $plant3->getActive(),
    'profile_image_id' => $plant3->getProfile_image_id(),
    'type' => $plant3->getType(),
    'curr_temperature' => $plant3->curr_temperature,
    'curr_humidity_air' => $plant3->curr_humidity_air,
    'curr_humidity_soil' => $plant3->curr_humidity_soil
  );

  array_push($plants_arr['data'], $plant_arr);
  array_push($plants_arr['data'], $plant_arr2);
  array_push($plants_arr['data'], $plant_arr3);

  // Make JSON
  print_r(json_encode($plants_arr, JSON_NUMERIC_CHECK, JSON_FORCE_OBJECT));
