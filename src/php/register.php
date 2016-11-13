<?php

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['username'])) {
  die('ERROR 1');
}
else if (!isset($input['password'])) {
  die('ERROR 2');
}
else if (!isset($input['firstName'])) {
  die('ERROR 3');
}
else if (!isset($input['lastName'])) {
  die('ERROR 4');
}
else if (!isset($input['email'])) {
  die('ERROR 5');
}

$username = $input['username'];
$password = $input['password'];
$firstName = $input['firstName'];
$lastName = $input['lastName'];
$email = $input['email'];

if (strlen($username) < 6 || strlen($username) > 255) {
  die('ERROR 6');
}

if (strlen($password) < 6 || strlen($password) > 255) {
  die('ERROR 7');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die('ERROR 8');
}

include_once('openDatabase.php');

// check if username exists

$sql = "
  SELECT id
  FROM soc_users
  WHERE username = ?
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 9');
}

$stmt->bind_param('s', $username);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$numRows = $stmt->fetch();

if ($numRows > 0) {
  die('ERROR 10');
}

$stmt->close();

// add new user

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "
  INSERT INTO soc_users
  (username, password, first_name, last_name, email)
  VALUES (?, ?, ?, ?, ?)
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 11');
}

$stmt->bind_param('sssss', $username, $hashedPassword, $firstName, $lastName, $email);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->close();

// get the id for this user

$sql = "
  SELECT id
  FROM soc_users
  WHERE username = ?
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 12');
}

$stmt->bind_param('s', $username);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->bind_result($userID);
$stmt->fetch();
$stmt->close();

// get the id for Cornell

$sql = "
  SELECT id
  FROM soc_users
  WHERE username='cmdaly'
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 13');
}

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->bind_result($cornellID);
$stmt->fetch();
$stmt->close();

// add Cornell as a friend of the new user

$sql = "
  INSERT INTO soc_friends
  (user_id, friend_id)
  VALUES (?, ?)
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 14');
}

$stmt->bind_param('dd', $userID, $cornellID);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

echo 'success';

$stmt->close();
$db->close();

?>