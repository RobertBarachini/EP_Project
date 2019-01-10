<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: DELETE");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../config/database.php';
  include_once '../objects/narocilo_artikel.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Narocilo_artikel($connection);

  // get object id
  $data = json_decode(file_get_contents("php://input"));
  // set object id to be deleted
  $object->idnarocila_artikli = $data->idnarocila_artikli;

  // delete the object
  if($object->delete()){
    http_response_code(204);
    echo json_encode(array("message" => "Object was deleted."));
  }
  else{
    http_response_code(404);
    echo json_encode(array("message" => "Unable to delete object."));
  }
?>