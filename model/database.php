<?php
class Database{
  private $servername;
  private $username;
  private $password;
  private $dbname;
  private $conn;
  public function __construct(){
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->dbname = "vitinhtt";
  }
  public function __destruct(){
    $this->servername = "";
    $this->username = "";
    $this->password = "";
    $this->dbname = "";
  }
  private function ketNoiDB(){
    $host=$this->servername;
    $user=$this->username;
    $pass=$this->password;
    $name=$this->dbname;
    try {
      $this->conn = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
      // set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo "Connected successfully";
      return true;
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      return false;
    }
  }
  private function huyKetNoiDB(){
    $this->conn = null;
  }
}
?>