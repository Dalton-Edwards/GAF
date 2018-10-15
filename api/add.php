<?php
require_once("core.php");
header("Content-type: application/json; charset=utf-8");
if (!isset($_POST["token"]) || !isset($_SESSION["token"]) || $_POST["token"] !== $_SESSION["token"]) {
  $error = "INVALID_TOKEN";
} else if (!isset($_SESSION["country"])) {
  $error = "MISSING_COUNTRY";
} else if (!isset($_POST["topic"]) || empty($_POST["topic"])) {
  $error = "MISSING_TOPIC";
} else if (!ctype_alnum($_POST["topic"])) {
  $error = "INVALID_TOPIC";
} else if (strlen($_POST["topic"]) > 20) {
  $error = "LONG_TOPIC";
} else if (badTopic(strtolower($_GET["topic"]))) {
  $error = "BAD_TOPIC";
} else {
  $topic = strtolower($_POST["topic"]);
  $country = $_SESSION["country"];
  addFuck($date, $topic);
  addLeaderboard($date, $topic, $country);
  $error = false;
}
$outputArray = array(
  "error" => $error
);
echo json_encode($outputArray, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
