
<?php
require('../database.php');
// Start the session to store user information if needed
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from POST data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $sql = "SELECT * FROM users WHERE username = '" . $username . "';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['permission_level'] = $user['permission_level'];
                $_SESSION['profile_pic'] = $user['profile_pic'];
                $_SESSION['member_since'] = $user['member_since'];
                $_SESSION['warnings'] = $user['warnings'];
                $_SESSION['primary_color'] = $user['primary_color'];
                $_SESSION['biography'] = $user['biography'];
                $_SESSION['birthday'] = $user['birthday'];
                header("Location: ../");
                exit();
            }
        }
    }
    header("Location: ./login.html");
    exit();
}
?>
