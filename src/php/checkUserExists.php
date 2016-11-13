<?php

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input["username"])) {
  die('ERROR 1');
}

$username = $input["username"];

include_once('openDatabase.php');

$sql = "
SELECT id
from soc_users users
WHERE username = ?
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 2');
}

$stmt->bind_param('s', $username);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$numRows = $stmt->fetch();

$stmt->close();
$db->close();

if ($numRows > 0) {
  echo 'true';
}
else {
  echo 'false';
}

?>