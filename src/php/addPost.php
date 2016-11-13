<?php

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input["recipientName"])) {
  die('ERROR 1');
}
else if (!isset($input["message"])) {
  die('ERROR 2');
}

include_once('openDatabase.php');

session_start();

if (!isset($_SESSION["loggedIn"]) || !isset($_SESSION["userID"])) {
  die('ERROR 3');
}

date_default_timezone_set('America/New_York');

$authorID = $_SESSION["userID"];
$recipientName = $input["recipientName"];
$message = $input["message"];
$dateTime = date("Y-m-d H:i:s");

$sql = "
SELECT id
from soc_users users
WHERE username = ?
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 4');
}

$stmt->bind_param('s', $recipientName);
$stmt->bind_result($recipientID);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->fetch();
$stmt->close();

$sql = "
  INSERT INTO soc_posts
  (author_id, recipient_id, message, time_posted)
  VALUES (?, ?, ?, ?)
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 5 ');
}

$stmt->bind_param('ssss', $authorID, $recipientID, $message, $dateTime);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->close();
$db->close();

echo 'success';

?>