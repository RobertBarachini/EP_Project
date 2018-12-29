<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../config/database.php';
  include_once '../objects/uporabnik.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Uporabnik($connection);

  // get posted data
  $data = json_decode(file_get_contents("php://input"));

  // make sure data is not empty
  if(
    !empty($data->ime) &&
    !empty($data->priimek)
  ){
    $object->ime = $data->ime;
    $object->priimek = $data->priimek;

    if($object->create()){
      http_response_code(201);
      echo json_encode(array("message" => "Object created."));
    }
    else{
      http_response_code(503);
      echo json_encode(array("message" => "Unable to create object."));
    }
  }
  else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create object. Data is incomplete."));
  }
?>