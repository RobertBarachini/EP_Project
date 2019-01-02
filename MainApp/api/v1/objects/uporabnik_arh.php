<?php
class Uporabnik{
  // database connection and table name
  private $connection;
  private $table_name = "uporabniki_arh";

  // object properties
  public $arh_akcija;
  public $arh_revizija;
  public $arh_datum;

  public $iduporabnika;
  public $idvloge;
  public $idcert;
  public $email;
  public $indmailpotrjen;
  public $geslo;
  public $sol;
  public $piskotek;
  public $ime;
  public $priimek;
  public $ulica;
  public $posta;
  public $kraj;
  public $drzava;
  public $datprijave;
  public $status;
  public $datspr;
  public $idspr;

  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }

  // CRUD
  public function read(){
    $query = "SELECT 
                arh_akcija, arh_revizija, arh_datum,
                iduporabnika, idvloge, idcert, email, indmailpotrjen, geslo, sol, piskotek, ime, priimek, 
                ulica, posta, kraj, drzava, datprijave, status, datspr, idspr
              FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                arh_akcija, arh_revizija, arh_datum,
                iduporabnika, idvloge, idcert, email, indmailpotrjen, geslo, sol, piskotek, ime, priimek, 
                ulica, posta, kraj, drzava, datprijave, status, datspr, idspr
              FROM
                  " . $this->table_name . "
              WHERE 
                  iduporabnika = ?
              LIMIT
                  0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of object to be updated
    $statement->bindParam(1, $this->iduporabnika);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->arh_akcija = $row['arh_akcija'];
    $this->arh_revizija = $row['arh_revizija'];
    $this->arh_datum = $row['arh_datum'];

    $this->arh_akcija = $row['arh_akcija'];
    $this->arh_revizija = $row['arh_revizija'];
    $this->arh_datum = $row['arh_datum'];

    $this->iduporabnika = $row['iduporabnika'];
    $this->idvloge = $row['idvloge'];
    $this->idcert = $row['idcert'];
    $this->email = $row['email'];
    $this->indmailpotrjen = $row['indmailpotrjen'];
    $this->geslo = $row['geslo'];
    $this->sol = $row['sol'];
    $this->piskotek = $row['piskotek'];
    $this->ime = $row['ime'];
    $this->priimek = $row['priimek'];
    $this->ulica = $row['ulica'];
    $this->posta = $row['posta'];
    $this->kraj = $row['kraj'];
    $this->drzava = $row['drzava'];
    $this->datprijave = $row['datprijave'];
    $this->status = $row['status'];
    $this->datspr = $row['datspr'];
    $this->idspr = $row['idspr'];
  }
}