<?php
$title = 'Photofox - Benutzer';
$currentPage = 'user_overview';
require_once('nav.php');
require('./database.php');
$sql = "SELECT * FROM users WHERE posts > 0;";
    $result = $conn->query($sql);

    // Fetch the user data
    if ($result->num_rows > 0) {
    // output data of each row
        while($user = $result->fetch_assoc()) {
            //show user
        }
    }
?>
  <body>
    
  </body>
