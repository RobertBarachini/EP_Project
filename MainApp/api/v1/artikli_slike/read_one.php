<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  include_once '../config/database.php';
  include_once '../objects/artikel_slika.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Artikel_slika($connection);

  // set property of record to read
  $object->idslike = isset($_GET['id']) ? $_GET['id'] : die();

  $object->readOne();

  if($object->idartikla!=null){
    $object_arr = array(
      "idslike" =>  $object->idslike,
      "idartikla" =>  $object->idartikla,
      "naziv" =>  $object->naziv,
      "link" =>  $object->link,
      "status" =>  $object->status,
      "datspr" =>  $object->datspr,
      "idspr" =>  $object->idspr
    );

    http_response_code(200);
    echo json_encode($object_arr);
  }
  else{
    http_response_code(404);
    echo json_encode(array("message" => "Object does not exist."));
  }
?>