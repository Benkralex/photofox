<?php
// Start the session to store user information if needed
session_start();
require('../database.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from POST data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $code = $_POST['code'];

    if (empty($username) || empty($password) || empty($email) || empty($name) || empty($code)) {
        header("Location: ./login.html");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ./login.html");
        exit();
    }
    if (strlen($password) < getPassReq()["MinLength"]) {
        header("Location: ./login.html");
        exit();
    }
    if (getPassReq()["CapitalLetter"]) {
        if (!preg_match('/[A-Z]/', $password)) {
            header("Location: ./login.html");
            exit();
        }
    }
    if (getPassReq()["SmallLetter"]) {
        if (!preg_match('/[a-z]/', $password)) {
            header("Location: ./login.html");
            exit();
        }
    }
    if (getPassReq()["Number"]) {
        if (!preg_match('/\d/', $password)) {
            header("Location: ./login.html");
            exit();
        }
    }
    if (getPassReq()["SpecialCharacter"]) {
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
            header("Location: ./login.html");
            exit();
        }
    }
    $password = password_hash($password, PASSWORD_DEFAULT, array('cost' => 9));

    // SQL-Abfrage zum Prüfen, ob der Code aktiv und unbenutzt ist
    $sql = "SELECT active, used FROM logincodes WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['active'] == 1 && $row['used'] == 0) {
            // Prepare and execute the SQL statement
            $sql = "INSERT INTO users (email, name, username, password, permission_level) VALUES (
                '" . $email . "',
                '" . $name . "',
                '" . $username . "',
                '" . $password . "',
                " . getDefaultPerm() . "
            );";
            $result = $conn->query($sql);

            $sql = "SELECT * FROM users WHERE username = '" . $username . "';";
            $result = $conn->query($sql);

            // Fetch the user data
            if ($result->num_rows > 0) {
                // output data of each row
                while ($user = $result->fetch_assoc()) {
                    if ($password == $user['password']) {
                        // Store user information in session or perform other login actions
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['name'] = $user['name'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['permission_level'] = $user['permission_level'];
                        $_SESSION['profile_pic'] = (($user['profile_pic'] != null) && ($user['profile_pic'] == "")) ? $user['profile_pic'] : getDefaultProfilePic();
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
        }
    }
    $stmt->close();
    header("Location: ./login.html");
    exit();
}
