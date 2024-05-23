<?php
$servername = "localhost";
$dbname = "photofox";
$dbusername = "photofoxDBuser";
$dbpassword = "#!2024passw0rdDB";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>