<?php
class Artikel_ocena{
  // database connection and table name
  private $connection;
  private $table_name = "artikli_ocene";

  // object properties
  public $idocene;
  public $idartikla;
  public $iduporabnika;
  public $ocena;
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
            (idartikla, iduporabnika, ocena, status, datspr, idspr) 
             VALUES
            (:idartikla, :iduporabnika, :ocena, 0, UTC_TIMESTAMP(), :idspr)";

    $statement = $this->connection->prepare($query);

    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->ocena=htmlspecialchars(strip_tags($this->ocena));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    $cas = time();
    $statement->bindParam(":idartikla", $this->idartikla);
    $statement->bindParam(":iduporabnika", $this->iduporabnika);
    $statement->bindParam(":ocena", $this->ocena);
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
                idocene, idartikla, iduporabnika, ocena, status, datspr, idspr 
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                idocene, idartikla, iduporabnika, ocena, status, datspr, idspr 
              FROM
                  " . $this->table_name . "
              WHERE 
                  idocene = ?
              LIMIT
                  0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam(1, $this->idocene);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->idocene = $row['idocene'];
    $this->idartikla = $row['idartikla'];
    $this->iduporabnika = $row['iduporabnika'];
    $this->ocena = $row['ocena'];
    $this->status = $row['status'];
    $this->datspr = $row['datspr'];
    $this->idspr = $row['idspr'];
  }

  public function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                idocene = :idocene,
                idartikla = :idartikla,
                iduporabnika = :iduporabnika,
                ocena = :ocena,
                status = :status,
                idspr = :idspr
              WHERE
                  idocene = :idocene";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idocene=htmlspecialchars(strip_tags($this->idocene));
    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->ocena=htmlspecialchars(strip_tags($this->ocena));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    // bind new values
    $statement->bindParam(':idocene', $this->idocene);
    //$statement->bindParam(':idvloge', $this->idvloge);
    //$statement->bindParam(':ime', $this->ime);
    //$statement->bindParam(':priimek', $this->priimek);
    $statement->bindParam(':idartikla', $this->idartikla);
    $statement->bindParam(':iduporabnika', $this->iduporabnika);
    $statement->bindParam(':ocena', $this->ocena);
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
    $query = "DELETE FROM " . $this->table_name . " WHERE idocene = ?";

    // prepare query
    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idocene=htmlspecialchars(strip_tags($this->idocene));
    // bind id of record to delete
    $statement->bindParam(1, $this->idocene);

    // execute query
    if($statement->execute()){
      return true;
    }
    return false;
  }
}