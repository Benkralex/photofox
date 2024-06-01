<?php
session_start();
require('./database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_POST['post_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = intval($_POST['post_id']);

    // Prüfen, ob der Benutzer den Post bereits geliked hat
    $check_like_stmt = $conn->prepare('SELECT * FROM likes WHERE user_id = ? AND post_id = ?');
    $check_like_stmt->bind_param('ii', $user_id, $post_id);
    $check_like_stmt->execute();
    $like_exists = $check_like_stmt->get_result()->num_rows > 0;

    if ($like_exists) {
        // Unlike
        $unlike_stmt = $conn->prepare('DELETE FROM likes WHERE user_id = ? AND post_id = ?');
        $unlike_stmt->bind_param('ii', $user_id, $post_id);
        $unlike_stmt->execute();
    } else {
        // Like
        $like_stmt = $conn->prepare('INSERT INTO likes (user_id, post_id) VALUES (?, ?)');
        $like_stmt->bind_param('ii', $user_id, $post_id);
        $like_stmt->execute();
    }
}

// Zurück zur Postseite
header("Location: post.php?id=" . $post_id);
exit();
