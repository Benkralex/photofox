<?php
require_once('../database.php');
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password']; // You may want to hash this password before storing it in the database
    $profile_pic = $_POST['profile_pic'];
    $primary_color = $_POST['primary_color'];
    $biography = $_POST['biography'];
    $birthday = $_POST['birthday'];

    // Update the database
    $sql = "UPDATE users SET name='$name', username='$username', password='$password', profile_pic='$profile_pic', primary_color='$primary_color', biography='$biography', birthday='$birthday' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        // Update session variables if needed
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['profile_pic'] = $profile_pic;
        $_SESSION['primary_color'] = $primary_color;
        $_SESSION['biography'] = $biography;
        $_SESSION['birthday'] = $birthday;
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
