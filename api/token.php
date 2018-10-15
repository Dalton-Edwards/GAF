<?php
require_once("core.php");
$_SESSION["country"] = $_SERVER["HTTP_CF_IPCOUNTRY"];
header("Content-type: application/json; charset=utf-8");
$_SESSION["token"] = bin2hex(random_bytes(16));
$token = $_SESSION["token"];
$tokenArray = array(
  "token" => $token
);
echo json_encode($tokenArray, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
