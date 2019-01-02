<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  include_once '../config/database.php';
  include_once '../objects/uporabnik_arh.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Uporabnik($connection);

  // set property of record to read
  $object->iduporabnika = isset($_GET['id']) ? $_GET['id'] : die();

  $object->readOne();

  if($object->ime!=null){
    $object_arr = array(
      "arh_akcija" => $object->arh_akcija,
      "arh_revizija" => $object->arh_revizija,
      "arh_datum" => $object->arh_datum,
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