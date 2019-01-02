<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: PUT");
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
  $object->iduporabnika = (isset($data->iduporabnika) ? $data->iduporabnika : null);
  $object->idvloge = (isset($data->idvloge) ? $data->idvloge : "X");
  $object->idcert = (isset($data->idcert) ? $data->idcert : null);
  $object->email = (isset($data->email) ? $data->email : null);
  $object->indmailpotrjen = (isset($data->indmailpotrjen) ? $data->indmailpotrjen : 0);
  $object->geslo = (isset($data->geslo) ? $data->geslo : null);
  $object->sol = (isset($data->sol) ? $data->sol : null);
  $object->piskotek = (isset($data->piskotek) ? $data->piskotek : null);
  $object->ime = (isset($data->ime) ? $data->ime : null);
  $object->priimek = (isset($data->priimek) ? $data->priimek : null);
  $object->ulica = (isset($data->ulica) ? $data->ulica : null);
  $object->posta = (isset($data->posta) ? $data->posta : null);
  $object->kraj = (isset($data->kraj) ? $data->kraj : null);
  $object->drzava = (isset($data->drzava) ? $data->drzava : null);
  $object->datprijave = (isset($data->datprijave) ? $data->datprijave : null);
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