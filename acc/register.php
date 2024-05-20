
<?php
require('../database.php');
// Start the session to store user information if needed
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from POST data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO users (email, name, username, password, permission_level) VALUES (
        '".$email."',
        '".$name."',
        '".$username."',
        '".$password."',
        2
    );";
    $result = $conn->query($sql);
    
    $sql = "SELECT * FROM users WHERE username = '".$username."';";
    $result = $conn->query($sql);

    // Fetch the user data
    if ($result->num_rows > 0) {
    // output data of each row
        while($user = $result->fetch_assoc()) {
            if ($password == $user['password']) {
                // Store user information in session or perform other login actions
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['permission_level'] = $user['permission_level'];
                header("Location: ../");
                exit();
            }
        }
    }
    header("Location: ./login.html");
    exit();
}
?>
