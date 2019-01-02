<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: PUT");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../config/database.php';
  include_once '../objects/uporabnik_potrditev.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Uporabnik_potrditev($connection);

  // get id of object to be edited
  $data = json_decode(file_get_contents("php://input"));

  // set ID property of object to be edited
  $object->idpotrditve = (isset($data->idpotrditve) ? $data->idpotrditve : null);
  $object->iduporabnika = (isset($data->iduporabnika) ? $data->iduporabnika : null);
  $object->datposiljanja = (isset($data->datposiljanja) ? $data->datposiljanja : null);
  $object->datpotrditve = (isset($data->datpotrditve) ? $data->datpotrditve : null);
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