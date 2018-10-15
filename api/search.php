<?php
if (!isset($_POST["topic"]) || empty($_POST["topic"])) {
  $topic = "giveafuck";
} else {
  $topic = strtolower($_POST["topic"]);
}
$x = trim(str_replace("#", "", $topic));
header("Location: https://giveafuck.club/topic/$x");
?>
