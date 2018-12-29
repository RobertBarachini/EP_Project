<?php
class Narocilo_artikel{
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
    // bind id of object to be updated
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
    $query = "UPDATE
                " . $this->table_name . "
              SET
                  ime = :ime,
                  priimek = :priimek
              WHERE
                  iduporabnika = :iduporabnika";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->ime=htmlspecialchars(strip_tags($this->ime));
    $this->priimek=htmlspecialchars(strip_tags($this->priimek));

    // bind new values
    $statement->bindParam(':iduporabnika', $this->iduporabnika);
    $statement->bindParam(':ime', $this->ime);
    $statement->bindParam(':priimek', $this->priimek);

    // execute the query
    if($statement->execute()){
      return true;
    }
    return false;
  }

  public function delete(){
    $query = "DELETE FROM " . $this->table_name . " WHERE iduporabnika = ?";

    // prepare query
    $statement = $this->connection->prepare($query);
    // sanitize
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    // bind id of record to delete
    $statement->bindParam(1, $this->iduporabnika);

    // execute query
    if($statement->execute()){
      return true;
    }
    return false;
  }
}