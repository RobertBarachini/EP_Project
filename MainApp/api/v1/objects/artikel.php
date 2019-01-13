<?php
class Artikel{
  // database connection and table name
  private $connection;
  private $table_name = "artikli";

  // object properties
  public $idartikla;
  public $naziv;
  public $opis;
  public $cena;
  public $st_ocen;
  public $povprecna_ocena;
  public $status;
  public $datspr;
  public $idspr;
  public $poizvedba;

  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }

  // CRUD
  public function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            (naziv, opis, cena, st_ocen, povprecna_ocena, status, datspr, idspr) 
             VALUES
            (:naziv, :opis, :cena, 0, 0, 0, UTC_TIMESTAMP(), :idspr)";

    $statement = $this->connection->prepare($query);

    $this->naziv=htmlspecialchars(strip_tags($this->naziv));
    $this->opis=htmlspecialchars(strip_tags($this->opis));
    $this->cena=htmlspecialchars(strip_tags($this->cena));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    $cas = time();
    $statement->bindParam(":naziv", $this->naziv);
    $statement->bindParam(":opis", $this->opis);
    $statement->bindParam(":cena", $this->cena);
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
                idartikla, naziv, opis, cena, st_ocen, povprecna_ocena, status, datspr, idspr 
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                idartikla, naziv, opis, cena, st_ocen, povprecna_ocena, status, datspr, idspr
              FROM
                  " . $this->table_name . "
              WHERE 
                  idartikla = ?
              LIMIT
                  0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam(1, $this->idartikla);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->idartikla = $row['idartikla'];
    $this->naziv = $row['naziv'];
    $this->opis = $row['opis'];
    $this->cena = $row['cena'];
    $this->st_ocen = $row['st_ocen'];
    $this->povprecna_ocena = $row['povprecna_ocena'];
    $this->status = $row['status'];
    $this->datspr = $row['datspr'];
    $this->idspr = $row['idspr'];
  }
    public function readQuery(){
    // query to read single record
    $query = "SELECT idartikla, naziv, opis, cena, st_ocen, povprecna_ocena, status, datspr, idspr FROM " .
      $this->table_name .
      " WHERE MATCH(naziv) AGAINST (:query IN BOOLEAN MODE)";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam("query", $this->poizvedba);
    // execute query
      $statement->execute();

    return $statement;
    // get retrieved row

  }




  public function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                idartikla = :idartikla,
                naziv = :naziv,
                opis = :opis,
                cena = :cena,
                st_ocen = :st_ocen,
                povprecna_ocena = :povprecna_ocena,
                status = :status,
                idspr = :idspr
              WHERE
                  idartikla = :idartikla";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    $this->naziv=htmlspecialchars(strip_tags($this->naziv));
    $this->opis=htmlspecialchars(strip_tags($this->opis));
    $this->cena=htmlspecialchars(strip_tags($this->cena));
    $this->st_ocen=htmlspecialchars(strip_tags($this->st_ocen));
    $this->povprecna_ocena=htmlspecialchars(strip_tags($this->povprecna_ocena));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    // bind new values
    $statement->bindParam(':idartikla', $this->idartikla);
    //$statement->bindParam(':idvloge', $this->idvloge);
    //$statement->bindParam(':ime', $this->ime);
    //$statement->bindParam(':priimek', $this->priimek);
    $statement->bindParam(':naziv', $this->naziv);
    $statement->bindParam(':opis', $this->opis);
    $statement->bindParam(':cena', $this->cena);
    $statement->bindParam(':st_ocen', $this->st_ocen);
    $statement->bindParam(':povprecna_ocena', $this->povprecna_ocena);
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
    $query = "DELETE FROM " . $this->table_name . " WHERE idartikla = ?";

    // prepare query
    $statement = $this->connection->prepare($query);
    // sanitize
    $this->idartikla=htmlspecialchars(strip_tags($this->idartikla));
    // bind id of record to delete
    $statement->bindParam(1, $this->idartikla);

    // execute query
    if($statement->execute()){
      return true;
    }
    return false;
  }
}