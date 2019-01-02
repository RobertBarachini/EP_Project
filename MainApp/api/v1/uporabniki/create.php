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
    $object->idvloge = (isset($data->idvloge) ? $data->idvloge : "X");
    $object->idcert = (isset($data->idcert) ? $data->idcert : null);
    $object->email = (isset($data->email) ? $data->email : null);
    $object->indmailpotrjen = (isset($data->indmailpotrjen) ? $data->indmailpotrjen : 0);
    $object->geslo = (isset($data->geslo) ? $data->geslo : null);
    $object->piskotek = (isset($data->piskotek) ? $data->piskotek : null);
    $object->ime = (isset($data->ime) ? $data->ime : null);
    $object->priimek = (isset($data->priimek) ? $data->priimek : null);
    $object->ulica = (isset($data->ulica) ? $data->ulica : null);
    $object->posta = (isset($data->posta) ? $data->posta : null);
    $object->kraj = (isset($data->kraj) ? $data->kraj : null);
    $object->drzava = (isset($data->drzava) ? $data->drzava : null);
    $object->status = (isset($data->status) ? $data->status : null);
    $object->idspr = (isset($data->idspr) ? $data->idspr : null);

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