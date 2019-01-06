<?php
class Narocilo_artikel{
  // database connection and table name
  private $connection;
  private $table_name = "narocila_artikli";

  // object properties
  public $idnarocila_artikli;
  public $idnarocila;
  public $idartikla;
  public $kolicina;
  public $status;
  public $datspr;
  public $idspr;

  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }

  // CRUD
  public function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            (idnarocila, idartikla, kolicina, status, datspr, idspr) 
             VALUES
            (:idnarocila, :idartikla, :kolicina, 0, UTC_TIMESTAMP(), :idspr)";

    $statement = $this->connection->prepare($query);

    $this->idnarocila=htmlspecialchars(strip_tags($this->idnarocila));
    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    $this->kolicina=htmlspecialchars(strip_tags($this->kolicina));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    $cas = time();
    $statement->bindParam(":idnarocila", $this->idnarocila);
    $statement->bindParam(":idartikla", $this->idartikla);
    $statement->bindParam(":kolicina", $this->kolicina);
    $statement->bindParam(":idspr", $this->idspr);

    $rez = $statement->execute();
    //$neki = $statement->debugDumpParams();
    //echo $neki;
    if($rez){
      $query = "SELECT LAST_INSERT_ID() id";
      $statement2 = $this->connection->prepare($query);
      $statement2->execute();
      $row = $statement2->fetch(PDO::FETCH_ASSOC);
      return $row['id'];
    }
    return -1;
  }

  public function read(){
    $query = "SELECT 
                idnarocila_artikli, idnarocila, idartikla, kolicina, status, datspr, idspr 
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                idnarocila_artikli, idnarocila, idartikla, kolicina, status, datspr, idspr
              FROM
                  " . $this->table_name . "
              WHERE 
                  idnarocila_artikli = ?
              LIMIT
                  0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam(1, $this->idnarocila_artikli);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->idnarocila_artikli = $row['idnarocila_artikli'];
    $this->idnarocila = $row['idnarocila'];
    $this->idartikla = $row['idartikla'];
    $this->kolicina = $row['kolicina'];
    $this->status = $row['status'];
    $this->datspr = $row['datspr'];
    $this->idspr = $row['idspr'];
  }

  public function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                idnarocila = :idnarocila,
                idartikla = :idartikla,
                kolicina = :kolicina,
                status = :status,
                idspr = :idspr
              WHERE
                  idnarocila_artikli = :idnarocila_artikli";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idnarocila_artikli=htmlspecialchars(strip_tags($this->idnarocila_artikli));
    $this->idnarocila=htmlspecialchars(strip_tags($this->idnarocila));
    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    $this->kolicina=htmlspecialchars(strip_tags($this->kolicina));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    // bind new values
    $statement->bindParam(':idnarocila_artikli', $this->idnarocila_artikli);
    //$statement->bindParam(':idvloge', $this->idvloge);
    //$statement->bindParam(':ime', $this->ime);
    //$statement->bindParam(':priimek', $this->priimek);
    $statement->bindParam(':idnarocila', $this->idnarocila);
    $statement->bindParam(':idartikla', $this->idartikla);
    $statement->bindParam(':kolicina', $this->kolicina);
    $statement->bindParam(":status", $this->status);
    $statement->bindParam(":idspr", $this->idspr);

    // execute the query
    $rez = $statement->execute();
    //$neki = $statement->debugDumpParams();
    //echo $neki;
    if($rez){
      return true;
    }
    return false;
  }

  public function delete(){
    $query = "DELETE FROM " . $this->table_name . " WHERE idnarocila_artikli = ?";

    // prepare query
    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idnarocila_artikli=htmlspecialchars(strip_tags($this->idnarocila_artikli));
    // bind id of record to delete
    $statement->bindParam(1, $this->idnarocila_artikli);

    // execute query
    if($statement->execute()){
      return true;
    }
    return false;
  }
}