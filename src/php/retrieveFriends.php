<?php

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input["user"])) {
  session_start();

  if (!isset($_SESSION["userID"])) {
    http_response_code(400);

    die('ERROR 1');
  }

  $userID = $_SESSION["userID"];
}
else {
  $username = $input["user"];
}

include_once('openDatabase.php');

if (!isset($userID)) {
  $sql = "
    SELECT id
    FROM soc_users
    WHERE username = ?
  ";

  if (!($stmt = $db->prepare($sql))) {
    die('ERROR 2');
  }

  $stmt->bind_param('s', $username);
  $stmt->bind_result($userID);

  if(!$stmt->execute()) {
    die('There was an error running the query [' . $db->error . ']');
  }

  $numRows = $stmt->fetch();

  if ($numRows == 0) {
    die('ERROR 3');
  }

  $stmt->close();
}

$sql = "
  SELECT users.username, users.email
  FROM soc_friends friends
  JOIN soc_users users on users.id = friends.friend_id
  WHERE friends.user_id = ?
  ORDER BY users.username
";

if (!($stmt = $db->prepare($sql))) {
  die('ERROR 4');
}

$stmt->bind_param('d', $userID);
$stmt->bind_result($resultUsername, $resultEmail);

if(!$stmt->execute()) {
  die('There was an error running the query [' . $db->error . ']');
}

$data = array();

while($stmt->fetch()) {
  $data[] = array(
    "username" => $resultUsername,
    "email" => $resultEmail
  );
}

echo json_encode($data);

$stmt->close();
$db->close();

?>

