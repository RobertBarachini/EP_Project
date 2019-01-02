<?php
class Artikel_arh{
  // database connection and table name
  private $connection;
  private $table_name = "artikli_arh";

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

  public $arh_akcija;
  public $arh_revizija;
  public $arh_datum;

  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }

  // CRUD
  public function read(){
    $query = "SELECT 
                arh_akcija, arh_revizija, arh_datum, idartikla, naziv, opis, cena, st_ocen, 
                povprecna_ocena, status, datspr, idspr
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                arh_akcija, arh_revizija, arh_datum, idartikla, naziv, opis, cena, st_ocen, 
                povprecna_ocena, status, datspr, idspr
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
    $this->arh_akcija = $row['arh_akcija'];
    $this->arh_revizija = $row['arh_revizija'];
    $this->arh_datum = $row['arh_datum'];
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
}