<?php
require_once('./database.php');
session_start();
$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_content'])) {
    $post_id = $_POST['post_id'];
    $comment_content = trim($_POST['comment_content']);
    if (!empty($comment_content)) {
        $insert_comment_stmt = $conn->prepare('INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)');
        $insert_comment_stmt->bind_param('iis', $user_id, $post_id, $comment_content);
        $insert_comment_stmt->execute();
        header("Location: ./post.php?id=$post_id");
        exit();
    }
}
