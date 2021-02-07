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

$response["success"] = false;
$response["data"] = array();
$response["message"] = "";

if (
    !empty($data->username) &&
    !empty($data->password)
) {
    $pengguna->username = $data->username;
    $pengguna->password = $data->password;
    $pengguna->id = $pengguna->login();
    if ($pengguna->id != 0) {

        $stmt = $pengguna->find();
        $row = $stmt->fetch();
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "id" => $row["id"],
                "username" => $row["username"],
                "namalengkap" => $row["namalengkap"]
            )
        );

        $jwt = JWT::encode($token, $key);

        http_response_code(200);
        $response["success"] = true;
        $response["data"] = $jwt;
        $response["message"] = "login berhasil";
    } else {
        http_response_code(503);
        $response["message"] = "login gagal";
    }
} else {

    http_response_code(400);
    $response["message"] = "lengkapi data login";
}
echo json_encode($response);
