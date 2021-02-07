<?php
include_once "../../config/api-header.php";
include_once "pengguna.php";

include_once '../../config/api-core.php';
include_once '../../config/php-jwt-master/src/BeforeValidException.php';
include_once '../../config/php-jwt-master/src/ExpiredException.php';
include_once '../../config/php-jwt-master/src/SignatureInvalidException.php';
include_once '../../config/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

$pengguna = new Pengguna($db);
$data = json_decode(file_get_contents("php://input"));
$jwt = isset($data->jwt) ? $data->jwt : "";

$response["success"] = false;
$response["data"] = array();
$response["message"] = "";

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        http_response_code(200);
        $response["success"] = true;
        $response["message"] = "Access granted.";
        $response["data"] = $decoded->data;
    } catch (Exception $e) {
        http_response_code(401);
        $response["message"] = "Access denied.";
    }
} else {
    http_response_code(401);
    $response["message"] = "Access denied.";
}
echo json_encode($response);
