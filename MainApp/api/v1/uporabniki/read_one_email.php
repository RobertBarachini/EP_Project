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
  $object->email = isset($_GET['email']) ? $_GET['email'] : die();

  $object->readOneEmail();

  if($object->ime!=null){
    $object_arr = array(
      "iduporabnika" => $object->iduporabnika,
      "idvloge" => $object->idvloge,
      "idcert" => $object->idcert,
      "email" => $object->email,
      "indmailpotrjen" => $object->indmailpotrjen,
      "geslo" => $object->geslo,
      "sol" => $object->sol,
      "piskotek" => $object->piskotek,
      "ime" => $object->ime,
      "priimek" => $object->priimek,
      "ulica" => $object->ulica,
      "posta" => $object->posta,
      "kraj" => $object->kraj,
      "drzava" => $object->drzava,
      "datprijave" => $object->datprijave,
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