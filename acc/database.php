<?php
$servername = "localhost";
$dbname = "photofox";
$dbusername = "photofox";
$dbpassword = "Ben.10.e";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>