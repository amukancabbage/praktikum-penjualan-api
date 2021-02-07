<?php
class Jenisbarang
{

  private $conn;
  public $id;
  public $namajenisbarang;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {
    $selectSQL = "SELECT * FROM jenisbarang";
    $stmt = $this->conn->prepare($selectSQL);
    $stmt->execute();

    return $stmt;
  }

  function find()
  {
    $selectSQL = "SELECT * FROM jenisbarang WHERE id = ?";
    $stmt = $this->conn->prepare($selectSQL);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    return $stmt;
  }

  function create()
  {
    $insertSQL = "INSERT INTO jenisbarang VALUES (NULL, ?)";
    $stmt = $this->conn->prepare($insertSQL);
    $stmt->bindParam(1, $this->namajenisbarang);

    if ($stmt->execute()) {
      return $this->conn->lastInsertId();
    }

    return 0;
  }

  function update()
  {
    $updateSQL = "UPDATE jenisbarang SET namajenisbarang = ? WHERE id = ?";
    $stmt = $this->conn->prepare($updateSQL);
    $stmt->bindParam(1, $this->namajenisbarang);
    $stmt->bindParam(2, $this->id);

    return $stmt->execute() ? true : false;
  }

  function delete()
  {
    $deleteSQL = "DELETE FROM jenisbarang WHERE id = ?";
    $stmt = $this->conn->prepare($deleteSQL);
    $stmt->bindParam(1, $this->id);
    return $stmt->execute() ? true : false;
  }
}
