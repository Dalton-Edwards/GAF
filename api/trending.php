<?php
require_once("core.php");
header("Content-type: application/json; charset=utf-8");
$items = glob("fucks/$date/*.txt", GLOB_NOSORT);
array_multisort(array_map('filesize', $items), SORT_NUMERIC, SORT_DESC, $items);
foreach ($items as $path) {
$topic = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($path));
$fucks = filesize($path);
$trending[] = array(
  "topic" => $topic,
  "fucks" => $fucks
);
}
echo json_encode($trending, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
