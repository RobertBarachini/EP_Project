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

  public function update(){
  }

  public function delete(){
  }
}