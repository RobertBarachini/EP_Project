<?php
class Narocilo{
  // database connection and table name
  private $connection;
  private $table_name = "narocila";

  // object properties
  public $idnarocila;
  public $iduporabnika;
  public $datzac_kosarice;
  public $datnarocila;
  public $datposiljanja;
  public $faza;
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
            (iduporabnika, faza, status, datspr, idspr) 
             VALUES
            (:iduporabnika, 'K', 0, UTC_TIMESTAMP(), :idspr)";

    $statement = $this->connection->prepare($query);

    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    $cas = time();
    $statement->bindParam(":iduporabnika", $this->iduporabnika);
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
                idnarocila, iduporabnika, datzac_kosarice, datnarocila, datposiljanja, faza, status, datspr, idspr 
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                idnarocila, iduporabnika, datzac_kosarice, datnarocila, datposiljanja, faza, status, datspr, idspr
              FROM
                  " . $this->table_name . "
              WHERE 
                  idnarocila = ?
              LIMIT
                  0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam(1, $this->idnarocila);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->idnarocila = $row['idnarocila'];
    $this->iduporabnika = $row['iduporabnika'];
    $this->datzac_kosarice = $row['datzac_kosarice'];
    $this->datnarocila = $row['datnarocila'];
    $this->datposiljanja = $row['datposiljanja'];
    $this->faza = $row['faza'];
    $this->status = $row['status'];
    $this->datspr = $row['datspr'];
    $this->idspr = $row['idspr'];
  }

  public function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                idnarocila = :idnarocila,
                iduporabnika = :iduporabnika,
                datnarocila = :datnarocila,
                datposiljanja = :datposiljanja,
                faza = :faza,
                status = :status,
                idspr = :idspr
              WHERE
                  idnarocila = :idnarocila";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idnarocila=htmlspecialchars(strip_tags($this->idnarocila));
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->datnarocila=htmlspecialchars(strip_tags($this->datnarocila));
    $this->datposiljanja=htmlspecialchars(strip_tags($this->datposiljanja));
    $this->faza=htmlspecialchars(strip_tags($this->faza));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    // bind new values
    $statement->bindParam(':idnarocila', $this->idnarocila);
    //$statement->bindParam(':idvloge', $this->idvloge);
    //$statement->bindParam(':ime', $this->ime);
    //$statement->bindParam(':priimek', $this->priimek);
    $statement->bindParam(':iduporabnika', $this->iduporabnika);
    $statement->bindParam(':datnarocila', $this->datnarocila);
    $statement->bindParam(':datposiljanja', $this->datposiljanja);
    $statement->bindParam(':faza', $this->faza);
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
    $query = "DELETE FROM " . $this->table_name . " WHERE idnarocila = ?";

    // prepare query
    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idnarocila=htmlspecialchars(strip_tags($this->idnarocila));
    // bind id of record to delete
    $statement->bindParam(1, $this->idnarocila);

    // execute query
    if($statement->execute()){
      return true;
    }
    return false;
  }
}