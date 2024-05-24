<?php
include './configs/config.php';

$conn = getDBConn();
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>