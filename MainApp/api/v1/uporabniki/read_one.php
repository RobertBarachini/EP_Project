<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  include_once '../config/database.php';
  include_once '../objects/uporabnik.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Uporabnik($connection);

  // set property of record to read
  $object->iduporabnika = isset($_GET['id']) ? $_GET['id'] : die();

  $object->readOne();

  if($object->ime!=null){
    $object_arr = array(
      "iduporabnika" =>  $object->iduporabnika,
      "ime" => $object->ime,
      "priimek" => $object->priimek,
    );

    http_response_code(200);
    echo json_encode($object_arr);
  }
  else{
    http_response_code(404);
    echo json_encode(array("message" => "Object does not exist."));
  }
?>