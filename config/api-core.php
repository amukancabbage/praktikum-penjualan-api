<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Singapore');
 
$key = "praktikum-penjualan-api-key";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60 * 24 * 7);
$issuer = "http://localhost/praktikum-penjualan-api";

?>