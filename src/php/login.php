<?php

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['username']) || !isset($input['password'])) {
  die('ERROR 1');
}

$username = $input['username'];
$password = $input['password'];

include_once('openDatabase.php');

$sql = "
  SELECT id, password
  FROM soc_users
  WHERE username = ?
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 2');
}

$stmt->bind_param('s', $username);
$stmt->bind_result($resultID, $resultPassword);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$stmt->fetch();

// https://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
// https://secure.php.net/password_hash
if (password_verify($password, $resultPassword)) {
  session_start();

  $_SESSION['loggedIn'] = true;
  $_SESSION['userID'] = $resultID;
  $_SESSION['username'] = $username;

  echo "success";
}
else {
  echo "failure";
}

?>