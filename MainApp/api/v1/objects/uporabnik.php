<?php
class Uporabnik{
  // database connection and table name
  private $connection;
  private $table_name = "uporabniki";

  // object properties
  public $iduporabnika;
  public $ime;
  public $priimek;

  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }

  // CRUD
  public function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                ime=:ime, 
                priimek=:priimek";

    $statement = $this->connection->prepare($query);

    $this->ime=htmlspecialchars(strip_tags($this->ime));
    $this->priimek=htmlspecialchars(strip_tags($this->priimek));

    $statement->bindParam(":ime", $this->ime);
    $statement->bindParam(":priimek", $this->priimek);

    if($statement->execute()){
      return true;
    }
    return false;
  }

  public function read(){
    $query = "SELECT iduporabnika, ime, priimek FROM " . $this->table_name;
    $statement = $this->connection->prepare($query);
    $statement->execute();
    return $statement;
  }

  public function readOne(){
    // query to read single record
    $query = "SELECT
                iduporabnika, ime, priimek
            FROM
                " . $this->table_name . "
            WHERE 
                iduporabnika = ?
            LIMIT
                0,1";

    // prepare query statement
    $statement = $this->connection->prepare( $query );
    // bind id of product to be updated
    $statement->bindParam(1, $this->iduporabnika);
    // execute query
    $statement->execute();
    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->iduporabnika = $row['iduporabnika'];
    $this->ime = $row['ime'];
    $this->priimek = $row['priimek'];
  }

  public function update(){
  }

  public function delete(){
  }
}