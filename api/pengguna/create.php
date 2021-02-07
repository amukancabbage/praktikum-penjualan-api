<?php
include_once "../../config/api-header.php";
include_once "pengguna.php";

$pengguna = new Pengguna($db);
$data = json_decode(file_get_contents("php://input"));

$response["success"] = false;
$response["data"] = array();
$response["message"] = "";

if (
    !empty($data->username) &&
    !empty($data->password) &&
    !empty($data->namalengkap)
) {
    $pengguna->username = $data->username;
    $pengguna->password = $data->password;
    $pengguna->namalengkap = $data->namalengkap;
    $pengguna->isadmin = $data->isadmin;

    $pengguna->id = $pengguna->create();
    if ($pengguna->id != 0) {
        $stmt = $pengguna->find();
        $row = $stmt->fetch();
        $response["data"] = array(
            "id" => $row["id"],
            "username" => $row["username"]
        );
        http_response_code(201);
        $response["success"] = true;
        $response["message"] = "create data pengguna berhasil";
    } else {
        http_response_code(503);
        $response["message"] = "create data pengguna gagal";
    }
} else {

    http_response_code(400);
    $response["message"] = "lengkapi data pengguna";
}
echo json_encode($response);
