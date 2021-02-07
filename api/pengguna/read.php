<?php
include_once "../../config/api-header.php";
include_once "pengguna.php";

$pengguna = new Pengguna($db);
$stmt = $pengguna->read();
$num = $stmt->rowCount();

$response["success"] = false;
$response["data"] = array();
$response["message"] = "";

if ($num > 0) {
  $response["success"] = true;
  $response["message"] = "read data pengguna berhasil";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pengguna_item = array(
      "id" => $row["id"],
      "username" => $row["username"],
      "isadmin" => $row["isadmin"]
    );
    array_push($response["data"], $pengguna_item);
  }

  http_response_code(200);
  echo json_encode($response);

} else {
  http_response_code(404);
  $response["message"] = "data pengguna masih kosong";
  echo json_encode($response);
}
