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
  public function themHoacXoa($query){
    $flag=$this->ketNoiDB();
    if($flag==true){
      $this->conn->exec($query);
      $this->huyKetNoiDB();
      return true;//them hoac xoa thanh cong
    }
    $this->huyKetNoiDB();
    return false;//them hoac xoa that bai
  }

  public function sua($query){
    $flag=$this->ketNoiDB();
    if($flag==true){
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // execute the query
      $stmt->execute();
      $this->huyKetNoiDB();
      return true;//sua thanh cong
    }
    $this->huyKetNoiDB();
    return false;//sua that bai
  }
  
  public function timDanhSach($query){
    $flag=$this->ketNoiDB();
    if($flag==true){
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $this->huyKetNoiDB();
      if($result==true){
        return $stmt->fetchAll();//tim thay tra ve mang danh sach cac doi tuong (tra ve kieu mang)
      }
    }
    $this->huyKetNoiDB();
    return null;//khong tim thay
  }
  public function timMotDoiTuong($query){
    $flag=$this->ketNoiDB();
    if($flag==true){
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $this->huyKetNoiDB();
      $arrDoiTuong=$stmt->fetchAll();
      $dem=count($arrDoiTuong);
      if($result==true && $dem>0){
        return $arrDoiTuong[0];//cau lenh truyen vao se tim 1 doi tuong nen lay doi tuong dau tien trong mang (tra ve kieu mang)
      }
    }
    $this->huyKetNoiDB();
    return null;//khong tim thay
  }
}
?>