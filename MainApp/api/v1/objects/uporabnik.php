<?php
class Uporabnik{
  // database connection and table name
  private $connection;
  private $table_name = "uporabniki";

  // object properties
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
  public function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            (idvloge, idcert, email, indmailpotrjen, geslo, sol, piskotek, ime, 
             priimek, ulica, posta, kraj, drzava, status, idspr, datprijave) 
             VALUES
            (:idvloge, :idcert, :email, :indmailpotrjen, :geslo, :sol, :piskotek, :ime, 
             :priimek, :ulica, :posta, :kraj, :drzava, 0, :idspr, UTC_TIMESTAMP())";

    $statement = $this->connection->prepare($query);

    $this->idvloge=htmlspecialchars(strip_tags($this->idvloge));
    $this->idcert=htmlspecialchars(strip_tags($this->idcert));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->indmailpotrjen=htmlspecialchars(strip_tags($this->indmailpotrjen));
    $this->geslo=htmlspecialchars(strip_tags($this->geslo));
    $this->geslo=htmlspecialchars(strip_tags($this->sol));
    $this->piskotek=htmlspecialchars(strip_tags($this->piskotek));
    $this->ime=htmlspecialchars(strip_tags($this->ime));
    $this->priimek=htmlspecialchars(strip_tags($this->priimek));
    $this->ulica=htmlspecialchars(strip_tags($this->ulica));
    $this->posta=htmlspecialchars(strip_tags($this->posta));
    $this->kraj=htmlspecialchars(strip_tags($this->kraj));
    $this->drzava=htmlspecialchars(strip_tags($this->drzava));
    $this->datprijave=htmlspecialchars(strip_tags($this->datprijave));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    $cas = time();
    $statement->bindParam(":idvloge", $this->idvloge);
    $statement->bindParam(":idcert", $this->idcert);
    $statement->bindParam(":email", $this->email);
    $statement->bindParam(":indmailpotrjen", $this->indmailpotrjen);
    $statement->bindParam(":geslo", $this->geslo);
    $statement->bindParam(":geslo", $this->sol);
    $statement->bindParam(":piskotek", $this->piskotek);
    $statement->bindParam(":ime", $this->ime);
    $statement->bindParam(":priimek", $this->priimek);
    $statement->bindParam(":ulica", $this->ulica);
    $statement->bindParam(":posta", $this->posta);
    $statement->bindParam(":kraj", $this->kraj);
    $statement->bindParam(":drzava", $this->drzava);
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

  public function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                idvloge = :idvloge,
                idcert = :idcert,
                email = :email,
                indmailpotrjen = :indmailpotrjen,
                geslo = :geslo,
                sol = :sol,
                piskotek = :piskotek,
                ime = :ime,
                priimek = :priimek,
                ulica = :ulica,
                posta = :posta,
                kraj = :kraj,
                drzava = :drzava,
                datprijave = :datprijave,
                status = :status,
                idspr = :idspr
              WHERE
                  iduporabnika = :iduporabnika";

    $statement = $this->connection->prepare($query);
    // sanitize
    $this->iduporabnika=htmlspecialchars(strip_tags($this->iduporabnika));
    $this->idvloge=htmlspecialchars(strip_tags($this->idvloge));
    $this->idcert=htmlspecialchars(strip_tags($this->idcert));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->indmailpotrjen=htmlspecialchars(strip_tags($this->indmailpotrjen));
    $this->geslo=htmlspecialchars(strip_tags($this->geslo));
    $this->sol=htmlspecialchars(strip_tags($this->sol));
    $this->piskotek=htmlspecialchars(strip_tags($this->piskotek));
    $this->ime=htmlspecialchars(strip_tags($this->ime));
    $this->priimek=htmlspecialchars(strip_tags($this->priimek));
    $this->ulica=htmlspecialchars(strip_tags($this->ulica));
    $this->posta=htmlspecialchars(strip_tags($this->posta));
    $this->kraj=htmlspecialchars(strip_tags($this->kraj));
    $this->drzava=htmlspecialchars(strip_tags($this->drzava));
    $this->datprijave=htmlspecialchars(strip_tags($this->datprijave));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->idspr=htmlspecialchars(strip_tags($this->idspr));

    // bind new values
    $statement->bindParam(':iduporabnika', $this->iduporabnika);
    //$statement->bindParam(':idvloge', $this->idvloge);
    //$statement->bindParam(':ime', $this->ime);
    //$statement->bindParam(':priimek', $this->priimek);

    $statement->bindParam(":idvloge", $this->idvloge);
    $statement->bindParam(":idcert", $this->idcert);
    $statement->bindParam(":email", $this->email);
    $statement->bindParam(":indmailpotrjen", $this->indmailpotrjen);
    $statement->bindParam(":geslo", $this->geslo);
    $statement->bindParam(":sol", $this->sol);
    $statement->bindParam(":piskotek", $this->piskotek);
    $statement->bindParam(":ime", $this->ime);
    $statement->bindParam(":priimek", $this->priimek);
    $statement->bindParam(":ulica", $this->ulica);
    $statement->bindParam(":posta", $this->posta);
    $statement->bindParam(":kraj", $this->kraj);
    $statement->bindParam(":drzava", $this->drzava);
    $statement->bindParam(":datprijave", $this->datprijave);
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