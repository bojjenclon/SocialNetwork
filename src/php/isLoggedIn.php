<?php
session_start();

echo isset($_SESSION['loggedIn']) ? 'true' : 'false';
?>

