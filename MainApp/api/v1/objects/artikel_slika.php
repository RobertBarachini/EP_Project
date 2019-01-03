<?php
class Artikel_slika{
  // database connection and table name
  private $connection;
  private $table_name = "artikli_slike";

  // object properties
  public $idslike;
  public $idartikla;
  public $naziv;
  public $link;
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
            (idartikla, naziv, link, status, idspr, datspr)
             VALUES
             (:idartikla, :naziv, :link, 0, :idspr, UTC_TIMESTAMP())";

    $statement = $this->connection->prepare($query);

    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    $this->naziv=htmlspecialchars(strip_tags($this->naziv));
    $this->link=htmlspecialchars(strip_tags($this->link));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    $cas = time();
    $statement->bindParam(":idartikla", $this->idartikla);
    $statement->bindParam(":naziv", $this->naziv);
    $statement->bindParam(":link", $this->link);
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
                idslike, idartikla, naziv, link, status, datspr, idspr
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                idslike, idartikla, naziv, link, status, datspr, idspr
              FROM
                  " . $this->table_name . "
              WHERE 
                  idslike = ?
              LIMIT
                  0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam(1, $this->idslike);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->idartikla = $row['idartikla'];
    $this->naziv = $row['naziv'];
    $this->link = $row['link'];
    $this->status = $row['status'];
    $this->datspr = $row['datspr'];
    $this->idspr = $row['idspr'];
  }

  public function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                idartikla = :idartikla,
                naziv = :naziv,
                link = :link,
                datspr = :datspr,
                status = :status,
                idspr = :idspr
              WHERE
                  idslike = :idslike";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idslike=htmlspecialchars(strip_tags($this->idslike));
    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    $this->naziv=htmlspecialchars(strip_tags($this->naziv));
    $this->link=htmlspecialchars(strip_tags($this->link));
    $this->datspr=htmlspecialchars(strip_tags($this->datspr));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    // bind new values
    $statement->bindParam(':idslike', $this->idslike);
    //$statement->bindParam(':idvloge', $this->idvloge);
    //$statement->bindParam(':ime', $this->ime);
    //$statement->bindParam(':priimek', $this->priimek);

    $statement->bindParam(":idartikla", $this->idartikla);
    $statement->bindParam(":naziv", $this->naziv);
    $statement->bindParam(":link", $this->link);
    $statement->bindParam(":datspr", $this->datspr);
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
    $query = "DELETE FROM " . $this->table_name . " WHERE idslike = ?";

    // prepare query
    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idslike=htmlspecialchars(strip_tags($this->idslike));
    // bind id of record to delete
    $statement->bindParam(1, $this->idslike);

    // execute query
    if($statement->execute()){
      return true;
    }
    return false;
  }
}