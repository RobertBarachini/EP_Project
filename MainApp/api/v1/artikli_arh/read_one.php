<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  include_once '../config/database.php';
  include_once '../objects/artikel_arh.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Artikel_arh($connection);

  // set property of record to read
  $object->idartikla = isset($_GET['id']) ? $_GET['id'] : die();

  $object->readOne();

  if($object->idartikla!=null){
    $object_arr = array(
      "arh_akcija" => $object->arh_akcija,
      "arh_revizija" => $object->arh_revizija,
      "arh_datum" => $object->arh_datum,
      "idartikla" => $object->idartikla,
      "naziv" => $object->naziv,
      "opis" => $object->opis,
      "cena" => $object->cena,
      "st_ocen" => $object->st_ocen,
      "povprecna_ocena" => $object->povprecna_ocena,
      "status" => $object->status,
      "datspr" => $object->datspr,
      "idspr" => $object->idspr
    );

    http_response_code(200);
    echo json_encode($object_arr);
  }
  else{
    http_response_code(404);
    echo json_encode(array("message" => "Object does not exist."));
  }
?>