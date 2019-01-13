<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/artikel.php';

$database = new Database();
$connection = $database->getConnection();


$object = new Artikel($connection);
// set property of record to read

$object->poizvedba = isset($_GET['poizvedba']) ? $_GET['poizvedba'] : die();

$statement=$object->readQuery();
$count = $statement->rowCount();

if($count > 0){
  $objects = array();
  $objects["body"] = array();
  $objects["count"] = $count;

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $p  = array(
      "idartikla" => $idartikla,
      "naziv" => $naziv,
      "opis" => $opis,
      "cena" => $cena,
      "st_ocen" => $st_ocen,
      "povprecna_ocena" => $povprecna_ocena,
      "status" => $status,
      "datspr" => $datspr,
      "idspr" => $idspr
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