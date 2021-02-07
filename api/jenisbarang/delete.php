<?php
include_once "../../config/api-header.php";
include_once 'jenisbarang.php';

$jenisbarang = new Jenisbarang($db);
$data = json_decode(file_get_contents("php://input"));

$response["success"] = false;
$response["data"] = array();
$response["message"] = "";

if (
    !empty($data->id)
) {
    $jenisbarang->id = $data->id;
    if ($jenisbarang->delete()) {
        http_response_code(201);
        $response["success"] = true;
        $response["message"] = "delete data jenisbarang berhasil";
    } else {
        http_response_code(503);
        $response["message"] = "delete data jenisbarang gagal";
    }
} else {
    http_response_code(400);
    $response["message"] = "lengkapi data jenisbarang";
}
echo json_encode($response);
