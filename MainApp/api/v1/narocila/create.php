<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../config/database.php';
  include_once '../objects/narocilo.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Narocilo($connection);

  // get posted data
  $data = json_decode(file_get_contents("php://input"));

  // make sure data is not empty
  if(
  true
    /*!empty($data->email) &&
    !empty($data->geslo) &&
    !empty($data->ime) &&
    !empty($data->priimek) &&
    !empty($data->ulica) &&
    !empty($data->posta) &&
    !empty($data->kraj) &&
    !empty($data->drzava)*/
  ){
    $object->iduporabnika = (isset($data->iduporabnika) ? $data->iduporabnika : -1);
    $object->idspr = (isset($data->idspr) ? $data->idspr : -1);

    $ret = $object->create();
    if($ret > -1){
      http_response_code(201);
      echo json_encode(array("id"=>$ret, "message" => "Object created"));
    }
    else{
      http_response_code(503);
      echo json_encode(array("id"=>$ret, "message" => "Unable to create object."));
    }
  }
  else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create object. Data is incomplete."));
  }
?>