<?php
require_once("core.php");
header("Content-type: application/json; charset=utf-8");
if (!isset($_GET["topic"]) || empty($_GET["topic"])) {
  $error = "Please pick a topic.";
} else if (!ctype_alnum($_GET["topic"])) {
  $error = "Topic name can only contain letters and numbers.";
} else if (strlen($_GET["topic"]) > 20) {
  $error = "Topic name cannot be longer than 20 characters.";
} else if (badTopic(strtolower($_GET["topic"]))) {
  $error = "You aren't allowed to give a fuck about this topic.";
} else {
  $topic = strtolower($_GET["topic"]);
  $count = getFucks($date, $topic);
  $error = false;
}
if ($error !== FALSE) {
  $outputArray = array(
    "error" => $error
  );
} else {
  $outputArray = array(
    "error" => $error,
    "fucks" => $count
  );
}
echo json_encode($outputArray, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
