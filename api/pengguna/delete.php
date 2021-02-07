<?php
include_once "../../config/api-header.php";
include_once 'pengguna.php';

$pengguna = new Pengguna($db);
$data = json_decode(file_get_contents("php://input"));

$response["success"] = false;
$response["data"] = array();
$response["message"] = "";

if (
    !empty($data->id)
) {
    $pengguna->id = $data->id;
    if ($pengguna->delete()) {
        http_response_code(201);
        $response["success"] = true;
        $response["message"] = "delete data pengguna berhasil";
    } else {
        http_response_code(503);
        $response["message"] = "delete data pengguna gagal";
    }
} else {
    http_response_code(400);
    $response["message"] = "lengkapi data pengguna";
}
echo json_encode($response);
