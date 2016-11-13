<?php

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input["friendName"])) {
  die('ERROR 1');
}

include_once('openDatabase.php');

session_start();

if (!isset($_SESSION["loggedIn"]) || !isset($_SESSION["userID"])) {
  die('ERROR 2');
}

$userID = $_SESSION["userID"];
$friendName = $input["friendName"];

$sql = "
SELECT id
from soc_users users
WHERE username = ?
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 3');
}

$stmt->bind_param('s', $friendName);
$stmt->bind_result($friendID);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->fetch();
$stmt->close();

$sql = "
  DELETE FROM soc_friends
  WHERE user_id = ? and friend_id = ?
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 4');
}

$stmt->bind_param('dd', $userID, $friendID);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->close();
$db->close();

echo 'true';

?>