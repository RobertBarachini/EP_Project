<?php
  // required headers
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

  // get id of object to be edited
  $data = json_decode(file_get_contents("php://input"));

  // set ID property of object to be edited
  $object->iduporabnika = $data->iduporabnika;
  $object->ime = $data->ime;
  $object->priimek= $data->priimek;

  if($object->update()){
    http_response_code(200);
    echo json_encode(array("message" => "Object was updated."));
  }
  else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update object."));
  }
?>