<?php
class Uporabnik_potrditev{
  // database connection and table name
  private $connection;
  private $table_name = "uporabniki_potrditve";

  // object properties
  public $idpotrditve;
  public $iduporabnika;
  public $datposiljanja;
  public $datpotrditve;
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
            (iduporabnika, datposiljanja, status, idspr) 
             VALUES
            (:iduporabnika, UTC_TIMESTAMP(), 0, :idspr)";

    $statement = $this->connection->prepare($query);

    $this->idpotrditve=htmlspecialchars(strip_tags($this->idpotrditve));
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->datposiljanja=htmlspecialchars(strip_tags($this->datposiljanja));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    $cas = time();
    $statement->bindParam(":iduporabnika", $this->iduporabnika);
    $statement->bindParam(":idspr", $this->idspr);

    $rez = $statement->execute();
    $neki = $statement->debugDumpParams();
    echo $neki;
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
                idpotrditve, iduporabnika, datposiljanja, datpotrditve, status, datspr, idspr
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                idpotrditve, iduporabnika, datposiljanja, datpotrditve, status, datspr, idspr
              FROM
                  " . $this->table_name . "
              WHERE 
                  idpotrditve = ?
              LIMIT
                  0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam(1, $this->idpotrditve);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->iduporabnika = $row['iduporabnika'];
    $this->datposiljanja = $row['datposiljanja'];
    $this->datpotrditve = $row['datpotrditve'];
    $this->status = $row['status'];
    $this->datspr = $row['datspr'];
    $this->idspr = $row['idspr'];
  }

  public function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                iduporabnika = :iduporabnika,
                datposiljanja = :datposiljanja,
                datpotrditve = :datpotrditve,
                status = :status,
                idspr = :idspr
              WHERE
                  idpotrditve = :idpotrditve";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idpotrditve=htmlspecialchars(strip_tags($this->idpotrditve));
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->datposiljanja=htmlspecialchars(strip_tags($this->datposiljanja));
    $this->datpotrditve=htmlspecialchars(strip_tags($this->datpotrditve));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    // bind new values
    $statement->bindParam(':idpotrditve', $this->idpotrditve);
    //$statement->bindParam(':idvloge', $this->idvloge);
    //$statement->bindParam(':ime', $this->ime);
    //$statement->bindParam(':priimek', $this->priimek);

    $statement->bindParam(":iduporabnika", $this->iduporabnika);
    $statement->bindParam(":datposiljanja", $this->datposiljanja);
    $statement->bindParam(":datpotrditve", $this->datpotrditve);
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
    $query = "DELETE FROM " . $this->table_name . " WHERE idpotrditve = ?";

    // prepare query
    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idpotrditve=htmlspecialchars(strip_tags($this->idpotrditve));
    // bind id of record to delete
    $statement->bindParam(1, $this->idpotrditve);

    // execute query
    if($statement->execute()){
      return true;
    }
    return false;
  }
}