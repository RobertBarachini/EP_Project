<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  include_once '../config/database.php';
  include_once '../objects/uporabnik_potrditev.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Uporabnik_potrditev($connection);

  // set property of record to read
  $object->idpotrditve = isset($_GET['id']) ? $_GET['id'] : die();

  $object->readOne();

  if($object->idpotrditve!=null){
    $object_arr = array(
      "idpotrditve" => $object->idpotrditve,
      "iduporabnika" => $object->iduporabnika,
      "datposiljanja" => $object->datposiljanja,
      "datpotrditve" => $object->datpotrditve,
      "status" => $object->status,
      "datspr" => $object->datspr,
      "idspr" => $object->idspr,
    );

    http_response_code(200);
    echo json_encode($object_arr);
  }
  else{
    http_response_code(404);
    echo json_encode(array("message" => "Object does not exist."));
  }
?>