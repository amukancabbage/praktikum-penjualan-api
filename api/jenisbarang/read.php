<?php
include_once "../../config/api-header.php";
include_once "jenisbarang.php";

$jenisbarang = new Jenisbarang($db);
$stmt = $jenisbarang->read();
$num = $stmt->rowCount();

$response["success"] = false;
$response["data"] = array();
$response["message"] = "";

if ($num > 0) {
  $response["success"] = true;
  $response["message"] = "read data jenisbarang berhasil";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $jenisbarang_item = array(
      "id" => $row["id"],
      "namajenisbarang" => $row["namajenisbarang"]
    );
    array_push($response["data"], $jenisbarang_item);
  }

  http_response_code(200);
  echo json_encode($response);

} else {
  http_response_code(404);
  $response["message"] = "data jenisbarang masih kosong";
  echo json_encode($response);
}
