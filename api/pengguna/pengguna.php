<?php
class Pengguna
{

  private $conn;
  public $id;
  public $username;
  public $password;
  public $namalengkap;
  public $isadmin;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {
    $selectSQL = "SELECT * FROM pengguna";
    $stmt = $this->conn->prepare($selectSQL);
    $stmt->execute();

    return $stmt;
  }

  function find()
  {
    $selectSQL = "SELECT * FROM pengguna WHERE id = ?";
    $stmt = $this->conn->prepare($selectSQL);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    return $stmt;
  }

  function create()
  {

    $this->password = md5($this->password);

    $insertSQL = "INSERT INTO pengguna VALUES (NULL, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($insertSQL);
    $stmt->bindParam(1, $this->username);
    $stmt->bindParam(2, $this->password);
    $stmt->bindParam(3, $this->namalengkap);
    $stmt->bindParam(4, $this->isadmin);

    if ($stmt->execute()) {
      return $this->conn->lastInsertId();
    }

    return 0;
  }

  function update()
  {

    $this->password = md5($this->password);

    $updateSQL = "UPDATE pengguna SET username = ?, password = ?, namalengkap = ?, isadmin = ? WHERE id = ?";
    $stmt = $this->conn->prepare($updateSQL);
    $stmt->bindParam(1, $this->username);
    $stmt->bindParam(2, $this->password);
    $stmt->bindParam(3, $this->namalengkap);
    $stmt->bindParam(4, $this->isadmin);
    $stmt->bindParam(5, $this->id);

    return $stmt->execute() ? true : false;
  }

  function delete()
  {
    $deleteSQL = "DELETE FROM pengguna WHERE id = ?";
    $stmt = $this->conn->prepare($deleteSQL);
    $stmt->bindParam(1, $this->id);
    return $stmt->execute() ? true : false;
  }

  function login()
  {

    $this->password = md5($this->password);

    $loginSQL = "SELECT * FROM pengguna WHERE username = ? AND password = ?";
    $stmt = $this->conn->prepare($loginSQL);
    $stmt->bindParam(1, $this->username);
    $stmt->bindParam(2, $this->password);
    if ($stmt->execute()) {
      if ($stmt->rowCount() > 0){
        $row = $stmt->fetch();
        return $row['id'];
      }
    }

    return 0;
  }
}
