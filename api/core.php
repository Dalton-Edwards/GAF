<?php
session_start();

date_default_timezone_set("America/New_York");

$date = date("m-d-Y");

function badTopic($topic) {
  $badWords = array(
    "nigger",
    "nigga",
    "kike",
    "wetback",
    "redlegs",
    "akata",
    "dago",
    "kaffir",
    "lekgoa",
    "makwerekwere",
    "spic",
    "gringo",
    "gaijin",
    "gook",
    "wop",
    "pietro",
    "hymie",
    "tranny",
    "trannie",
    "fag",
    "faggot"
  );
  $matches = array();
  $matchFound = preg_match_all("/(" . implode($badWords,"|") . ")/i", $topic, $matches);
  if ($matchFound) {
    return true;
  } else {
    return false;
  }
}

function setup($date) {
  if (!file_exists("fucks/$date")) {
    mkdir("fucks/$date", 0777, true);
  }
}

function leaderboardSetup($date, $topic) {
  if (!file_exists("leaderboard/$date/$topic")) {
    mkdir("leaderboard/$date/$topic", 0777, true);
  }
}

function getFucks($date, $topic) {
  setup($date);
  if (file_exists("fucks/$date/$topic.txt")) {
    return filesize("fucks/$date/$topic.txt");
  } else {
    return 0;
  }
}

function addFuck($date, $topic) {
  setup($date);
  $file = "fucks/$date/$topic.txt";
  $current = file_get_contents($file);
  $current .= "x";
  $addFuck = file_put_contents($file, $current);
  if ($addFuck !== false) {
    return true;
  } else {
    return false;
  }
}

function addLeaderboard($date, $topic, $country) {
  leaderboardSetup($date, $topic);
  $file = "leaderboard/$date/$topic/$country.txt";
  $current = file_get_contents($file);
  $current .= "x";
  $addLeaderboard = file_put_contents($file, $current);
  if ($addLeaderboard !== false) {
    return true;
  } else {
    return false;
  }
}
