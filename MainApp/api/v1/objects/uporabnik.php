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