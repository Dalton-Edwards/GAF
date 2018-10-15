<?php
require_once("core.php");
header("Content-type: application/json; charset=utf-8");
if (!isset($_GET["topic"]) || empty($_GET["topic"])) {
  $error = "Please pick a topic.";
} else {
  $topic = strtolower($_GET["topic"]);
  $items = glob("leaderboard/$date/$topic/*.txt", GLOB_NOSORT);
  array_multisort(array_map('filesize', $items), SORT_NUMERIC, SORT_DESC, $items);
  foreach ($items as $path) {
  $country = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($path));
  $fucks = filesize($path);
  $leaderboard[] = array(
    "country" => $country,
    "fucks" => $fucks
  );
  }
  $error = false;
}
echo json_encode($leaderboard, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
?>
