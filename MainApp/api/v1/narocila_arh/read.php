<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  include_once '../config/database.php';
  include_once '../objects/uporabnik.php';

  $database = new Database();
  $connection = $database->getConnection();

  $object = new Uporabnik($connection);

  $statement = $object->read();
  $count = $statement->rowCount();

  if($count > 0){
    $objects = array();
    $objects["body"] = array();
    $objects["count"] = $count;

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      $p  = array(
        "id" => $iduporabnika,
        "ime" => $ime,
        "priimek" => $priimek,
      );
      array_push($objects["body"], $p);
    }

    http_response_code(200);
    echo json_encode($objects);
  }
  else {
    http_response_code(404);
    echo json_encode(
      array("message" => "No objects found.")
    );
  }
?>