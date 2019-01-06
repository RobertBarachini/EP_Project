<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  include_once '../config/database.php';
  include_once '../objects/narocilo.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Narocilo($connection);

  // set property of record to read
  $object->idnarocila = isset($_GET['id']) ? $_GET['id'] : die();

  $object->readOne();

  if($object->iduporabnika!=null){
    $object_arr = array(
      "idnarocila" => $object->idnarocila,
      "iduporabnika" => $object->iduporabnika,
      "datzac_kosarice" => $object->datzac_kosarice,
      "datnarocila" => $object->datnarocila,
      "datposiljanja" => $object->datposiljanja,
      "faza" => $object->faza,
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