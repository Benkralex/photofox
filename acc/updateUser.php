<?php
require_once('../database.php');
session_start();

function updateUserDetail($conn, $username, $field, $newValue)
{
    $allowedFields = ['email', 'name', 'username', 'primary_color', 'biography', 'birthday'];

    if (!in_array($field, $allowedFields)) {
        return;
    }

    $sql = "UPDATE users SET " . $field . " = ? WHERE username = ?";

    echo $sql;
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $newValue, $username);

        $stmt->execute();

        $stmt->close();
        $_SESSION[$field] = $newValue;
    }
}
updateUserDetail($conn, $_SESSION['username'], $_GET['field'], $_GET['value']);
header("Location: ./");
exit();
