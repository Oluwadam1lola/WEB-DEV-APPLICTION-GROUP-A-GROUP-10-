<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "enrollment";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>