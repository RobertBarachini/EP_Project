<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: PUT");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../config/database.php';
  include_once '../objects/artikel_slika.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Artikel_slika($connection);

  // get id of object to be edited
  $data = json_decode(file_get_contents("php://input"));

  // set ID property of object to be edited
  $object->idslike = (isset($data->idslike) ? $data->idslike : null);
  $object->idartikla = (isset($data->idartikla) ? $data->idartikla : null);
  $object->naziv = (isset($data->naziv) ? $data->naziv : null);
  $object->link = (isset($data->link) ? $data->link : null);
  $object->datspr = (isset($data->datspr) ? $data->datspr : null);
  $object->status = (isset($data->status) ? $data->status : null);
  $object->idspr = (isset($data->idspr) ? $data->idspr : -1);

  if($object->update()){
    http_response_code(200);
    echo json_encode(array("message" => "Object was updated."));
  }
  else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update object."));
  }
?>